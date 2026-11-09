<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\VpnApprovalRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\VPNRequest;

//Models
use App\Models\VpnForm;
use App\Models\FormApprover;
use App\Models\RapidxUser;

class FormsController extends Controller
{
    public function forms()
    {
        // if (session_status() === PHP_SESSION_NONE) {
        //     session_start();
        // }

        session_start();

        return view('forms', [
            'vpnControlNo' => $this->next_controlno_vpn(),
        ]);
    }

    public function vpn_list()
    {
        session_start();

        $vpn_list = VpnForm::with('approver')
            ->where('emp_no', $_SESSION['rapidx_employee_number'] ?? '');

        $stages = ['iss_manager', 'admin_avp', 'admin_president', 'iss_hardware'];
        $names = [];

        $defaultIssHardwareId = 'ISS Hardware'; 

        return DataTables::of($vpn_list)
            ->addColumn('approvers', function ($form) use ($stages, &$names, $defaultIssHardwareId) {
                if (!$form->approver) {
                    return '';
                }

                $badgeClass = [1 => 'bg-warning', 2 => 'bg-success', 3 => 'bg-danger'];
                $html = '';

                // 1. Alamin muna natin kung may nag-disapproved na kahit saang stage (status == 3)
                $hasDisapproved = false;
                foreach ($stages as $s) {
                    $sKey = $s . '_approval_status';
                    if (isset($form->approver->$sKey) && (int) $form->approver->$sKey === 3) {
                        $hasDisapproved = true;
                        break;
                    }
                }

                foreach ($stages as $stage) {
                    $userId = $form->approver->$stage;
                    $isDefaultIssHardware = false;

                    if ($stage === 'iss_hardware' && empty($userId)) {
                        $userId = $defaultIssHardwareId;
                        $isDefaultIssHardware = true; 
                    }

                    if (!array_key_exists($userId, $names)) {
                        $names[$userId] = optional(RapidxUser::find($userId))->name;
                    }

                    // 2. Logic para sa kulay ng badge
                    if ($stage === 'iss_hardware') {
                        if ($hasDisapproved) {
                            // Kapag may nag-disapproved sa kahit anong stage, red/danger ang ISS Hardware
                            $class = 'bg-danger';
                        } elseif (!$isDefaultIssHardware) {
                            // Kapag may laman na at walang nag-disapproved, success/green
                            $class = 'bg-success';
                        } else {
                            // Kapag default pa lang at walang nag-disapproved, susunod sa status o warning
                            $statusKey = $stage . '_approval_status';
                            $status = isset($form->approver->$statusKey) ? (int) $form->approver->$statusKey : 1; 
                            $class = $badgeClass[$status] ?? 'bg-secondary';
                        }
                    } else {
                        // Para sa ibang stages (iss_manager, admin_avp, admin_president)
                        $statusKey = $stage . '_approval_status';
                        $status = isset($form->approver->$statusKey) ? (int) $form->approver->$statusKey : 1; 
                        $class = $badgeClass[$status] ?? 'bg-secondary';
                    }

                    $html .= '<div class="mb-1 text-center"><span class="p-2 badge ' . $class . '">'
                        . e($names[$userId] ?? $userId) . '</span></div>';
                }

                return $html;
            })
            ->addColumn('action', function ($form) {
                return '<button class="btn btn-sm btn-primary viewVpnRequestDetails" data-id="' . $form->id . '" type="button">'
                    . '<i class="fas fa-eye"></i></button>';
            })
            ->rawColumns(['approvers', 'action'])
            ->toJson();
    }

    public function show_vpn($id)
    {
        session_start();

        $empNo = $_SESSION['rapidx_employee_number'] ?? '';

        $vpnForm = VpnForm::with('approver')->findOrFail($id);

        // the requestor can open their own request; hardware employees can open fully approved ones
        if ($vpnForm->emp_no !== $empNo) {
            $isHardware = in_array($empNo, config('forms.hardware_employee_numbers'));

            abort_unless($isHardware && $vpnForm->isFullyApproved(), 404);
        }

        $approver = FormApprover::where('form_type', 'VPN')
            ->where('fk_control_no', (string) $vpnForm->id)
            ->first();

        $approverEmpNos = $approver
            ? RapidxUser::whereIn('id', [$approver->iss_manager, $approver->admin_avp, $approver->admin_president])
                ->pluck('employee_number', 'id')
            : collect();

        $approvals = [];
        foreach (['iss_manager', 'admin_avp', 'admin_president'] as $stage) {
            $date = $approver ? $approver->{$stage . '_date'} : null;

            $approvals[$stage] = [
                'status' => $approver ? (int) $approver->{$stage . '_approval_status'} : 0, // 1=pending, 2=approved, 3=disapproved
                'date' => $date ? Carbon::parse($date)->format('M d, Y') : null,
                'remarks' => $approver ? $approver->{$stage . '_remarks'} : null,
                // only shown once approved
                'signature' => $approver && (int) $approver->{$stage . '_approval_status'} === 2
                    ? $this->signature_url($approverEmpNos[$approver->$stage] ?? null)
                    : null,
            ];
        }

        return response()->json([
            'control_no' => $vpnForm->control_no,
            'emp_no' => $vpnForm->emp_no,
            'name' => $vpnForm->name,
            'department_section' => $vpnForm->department_section,
            'position' => $vpnForm->position,
            'type_of_request' => $vpnForm->type_of_request,
            'purpose' => $vpnForm->purpose,
            'date_from' => $vpnForm->date_from,
            'date_to' => $vpnForm->date_to,
            'access_location' => $vpnForm->access_location,
            'device_name' => $vpnForm->device_name,
            'asset_tag' => $vpnForm->asset_tag,
            'date_requested' => $vpnForm->created_at->format('Y-m-d'),
            'requestor_signature' => $this->signature_url($vpnForm->emp_no),
            'approvals' => $approvals,
            'iss_details' => $vpnForm->vpn_iss_details[0] ?? [],
            // once hardware has saved its part, it is shown to the requestor and can no longer be edited
            'iss_locked' => $approver && !empty($approver->iss_hardware),
        ]);
    }

    public function store_vpn(VPNRequest $request)
    {
        $validated = $request->validated();

        $vpnForm = DB::connection('mysql')->transaction(function () use ($validated) {
            $controlNo = $this->next_controlno_vpn(true);

            $vpnForm = VpnForm::create([
                'control_no' => $controlNo,
                'emp_no' => $validated['employee_no'],
                'name' => $validated['employee_name'],
                'department_section' => $validated['department'],
                'position' => $validated['position'],
                'type_of_request' => $validated['request_type'],
                'purpose' => $validated['purpose'],
                'date_from' => $validated['date_from'],
                'date_to' => $validated['date_to'],
                'access_location' => $validated['location'],
                'device_name' => $validated['device_name'],
                'asset_tag' => $validated['asset_tag'],
                'status' => 1,
                'vpn_iss_details' => [
                    ['vpn_access_status' => '',
                     'forticlient_vpn_installed' => '',
                     'fortitoken_mobile_mfa_configured' => '',
                     'vpn_user_account_created' => '',
                     'access_restrictions_applied' => '',
                     'activation_date' => '',
                     'expiration_date' => '',
                    ],
                ],
            ]);

            FormApprover::create([
                'fk_control_no' => (string) $vpnForm->id,
                'form_type' => 'VPN',
                'iss_manager' => 3,
                'admin_avp' => 15,
                'admin_president' => 147,
            ]);

            return $vpnForm;
        });

        $this->notifyFirstApprover($vpnForm);

        return response()->json([
            'id' => $vpnForm->id,
            'next_control_no' => $this->next_controlno_vpn(),
            'message' => 'Success',
        ], 201);
    }

    // Sent after the request is saved; a mail failure is logged and must not undo or fail the saved request.
    private function notifyFirstApprover($vpnForm)
    {
        try {
            $approver = RapidxUser::find(optional($vpnForm->approver)->iss_manager);

            $to = config('mail.test_recipient') ?: optional($approver)->email;

            if (empty($to)) {
                Log::warning("VPN {$vpnForm->control_no}: first approver has no email, notification skipped.");
                return;
            }

            Mail::to($to)->send(new VpnApprovalRequest($vpnForm, optional($approver)->name));
        } catch (\Throwable $e) {
            Log::error("VPN {$vpnForm->control_no}: unable to email first approver. " . $e->getMessage());
        }
    }

    // Signature files "Rapidxv2 Systems\RapidX_E-Signature\{employee no}.png|jpg"
    private function signature_file($empNo)
    {
        $empNo = basename((string) $empNo);

        if ($empNo === '') {
            return null;
        }

        foreach (['png', 'jpg', 'jpeg'] as $ext) {
            $path = base_path("../RapidX_E-Signature/{$empNo}.{$ext}");

            if (is_file($path)) {
                return $path;
            }
        }

        return null;
    }

    private function signature_url($empNo)
    {
        return $this->signature_file($empNo) ? route('forms.signature', ['empNo' => $empNo]) : null;
    }

    public function signature($empNo)
    {
        session_start();

        $file = isset($_SESSION['rapidx_employee_number']) ? $this->signature_file($empNo) : null;

        return response()->file($file);
    }

    private function next_controlno_vpn($lock = false)
    {
        $query = VpnForm::orderByDesc('id');

        $lastControlNo = $query->value('control_no');
        $nextNumber = 1;

        if ($lastControlNo !== null) {
            if (!preg_match('/^(?:ISS-VPN-)?(\d+)$/', $lastControlNo, $matches)) {
                throw new \UnexpectedValueException('The latest VPN control number has an invalid format.');
            }

            $nextNumber = (int) $matches[1] + 1;
        }

        return 'ISS-VPN-' . str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);
    }
}