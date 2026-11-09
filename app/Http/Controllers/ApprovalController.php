<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApprovalActionRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

//Mail
use App\Mail\VpnApprovalRequest;
use App\Mail\VpnRequestApproved;
use App\Mail\VpnRequestDisapproved;

//Models
use App\Models\VpnForm;
use App\Models\FormApprover;
use App\Models\RapidxUser;

class ApprovalController extends Controller
{
    // stage => stage that must be approved before it, in order of approval
    private const STAGES = [
        'iss_manager' => null,
        'admin_avp' => 'iss_manager',
        'admin_president' => 'admin_avp',
    ];

    private const STAGE_LABELS = [
        'iss_manager' => 'ISS Manager',
        'admin_avp' => 'Assistant Vice President',
        'admin_president' => 'President',
    ];

    // vpn_forms.status after a stage approves: 1=iss_manager, 2=assistant_vice_president, 3=president, 4=completed
    private const NEXT_FORM_STATUS = [
        'iss_manager' => 2,
        'admin_avp' => 3,
        'admin_president' => 4,
    ];

    private function currentUserId()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return (string) ($_SESSION['rapidx_user_id'] ?? '');
    }

    public function approval()
    {
        return view('approval');
    }

    // Requests that are waiting for the logged-in user's approval now.
    public function approval_list()
    {
        $userId = $this->currentUserId();

        $pending = FormApprover::where('form_type', 'VPN')->where(function ($query) use ($userId) {
                foreach (array_keys(self::STAGES) as $stage) {
                    $query->orWhere($stage, $userId);
                }
            })
            ->get()
            ->filter(fn ($approver) => $this->currentStage($approver, $userId) !== null);

        return DataTables::of(VpnForm::whereIn('id', $pending->pluck('fk_control_no')))
            ->addColumn('request', fn () => 'VPN Request')
            ->addColumn('action', function ($form) {
                $data = 'data-id="' . $form->id . '" data-control-no="' . e($form->control_no) . '"';

                return '<button class="btn btn-sm btn-primary approvalAction" ' . $data . ' data-action="approve" type="button">Approve</button> '
                    . '<button class="btn btn-sm btn-danger approvalAction" ' . $data . ' data-action="disapprove" type="button">Disapprove</button>';
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function vpn_action(ApprovalActionRequest $request)
    {
        $validated = $request->validated();

        $userId = $this->currentUserId();

        $result = (new FormApprover)->getConnection()->transaction(function () use ($validated, $userId) {
            // where('form_type', 'VPN')->
            $approver = FormApprover::where('fk_control_no', (string) $validated['id'])
                ->lockForUpdate()
                ->first();

            // re-checked inside the transaction so the sequence cannot be skipped or approved twice
            $stage = $approver ? $this->currentStage($approver, $userId) : null;

            if ($stage === null) {
                return false;
            }

            $approved = $validated['action'] === 'approve';

            $approver->{$stage . '_approval_status'} = $approved ? 2 : 3;
            $approver->{$stage . '_date'} = Carbon::now()->toDateString();
            $approver->{$stage . '_remarks'} = $validated['remarks'] ?? null;

            // a disapproval carries over: every later stage is disapproved too
            if (!$approved) {
                $stages = array_keys(self::STAGES);

                foreach (array_slice($stages, array_search($stage, $stages) + 1) as $later) {
                    $approver->{$later . '_approval_status'} = 3;
                    $approver->{$later . '_remarks'} = 'Disapproved by ' . self::STAGE_LABELS[$stage];
                }
            }

            $approver->save();

            if ($approved) {
                VpnForm::where('id', $validated['id'])->update(['status' => self::NEXT_FORM_STATUS[$stage]]);
            }

            return $stage;
        });

        if (!$result) {
            return response()->json(['message' => 'This request is not pending for your approval.'], 403);
        }

        $this->sendNotification($validated, $result);

        return response()->json(['message' => 'Success']);
    }

    // Approved: email the requestor and the next approver. Disapproved: email the requestor. Mail failures are logged only,
    // so they never undo the decision that was already saved.
    private function sendNotification($validated, $stage)
    {
        try {
            $vpnForm = VpnForm::with('approver')->findOrFail($validated['id']);

            if ($validated['action'] === 'disapprove') {
                $decider = RapidxUser::find($vpnForm->approver->$stage);
                $requestor = RapidxUser::where('employee_number', $vpnForm->emp_no)->first();

                $this->send($requestor, $vpnForm, new VpnRequestDisapproved(
                    $vpnForm,
                    optional($decider)->name,
                    $validated['remarks'] ?? null
                ));

                return;
            }

            $stages = array_keys(self::STAGES);
            $next = $stages[array_search($stage, $stages) + 1] ?? null;

            // tell the requestor who approved; the last stage means the request is completed
            $decider = RapidxUser::find($vpnForm->approver->$stage);
            $requestor = RapidxUser::where('employee_number', $vpnForm->emp_no)->first();

            $this->send($requestor, $vpnForm, new VpnRequestApproved(
                $vpnForm,
                self::STAGE_LABELS[$stage],
                optional($decider)->name,
                $next === null
            ));

            if ($next === null) {
                return;
            }

            $nextApprover = RapidxUser::find($vpnForm->approver->$next);

            $this->send($nextApprover, $vpnForm, new VpnApprovalRequest($vpnForm, optional($nextApprover)->name));
        } catch (\Throwable $e) {
            Log::error("VPN request {$validated['id']}: notification failed. " . $e->getMessage());
        }
    }

    private function send($recipient, $vpnForm, $mailable)
    {
        $to = config('mail.test_recipient') ?: optional($recipient)->email;

        if (empty($to)) {
            Log::warning("VPN {$vpnForm->control_no}: recipient has no email, notification skipped.");
            return;
        }

        Mail::to($to)->send($mailable);
    }

    // The stage the user may act on now: it is still pending and every earlier stage is approved.
    private function currentStage(FormApprover $approver, $userId)
    {
        if ($userId === '') {
            return null;
        }

        foreach (self::STAGES as $stage => $previous) {
            if ((string) $approver->$stage !== $userId) {
                continue;
            }

            if ((int) $approver->{$stage . '_approval_status'} !== 1) {
                continue;
            }

            if ($previous !== null && (int) $approver->{$previous . '_approval_status'} !== 2) {
                continue;
            }

            return $stage;
        }

        return null;
    }
}