<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\VpnIssDetailsRequest;
use App\Models\VpnForm;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HardwareController extends Controller
{
    public function hardware()
    {
        // if (session_status() === PHP_SESSION_NONE) {
        //     session_start();
        // }

        session_start();

        return view('hardware');
    }

    // VPN requests approved by the ISS Manager, Assistant Vice President and President (status 2 = approved).
    public function hardware_list()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        abort_unless(in_array($_SESSION['rapidx_employee_number'] ?? '', config('forms.hardware_employee_numbers')), 403);

        $query = VpnForm::whereHas('approver', function ($approver) {
            $approver->where('iss_manager_approval_status', 2)
                ->where('admin_avp_approval_status', 2)
                ->where('admin_president_approval_status', 2);
        });

        return DataTables::of($query)
            ->addColumn('request', fn () => 'VPN Request')
            ->addColumn('action', function ($form) {
                // the view modal is the VPN form partial; its click handler is bound to this class
                return '<button class="btn btn-sm btn-primary viewVpnRequestDetails" data-id="' . $form->id . '" type="button">'
                    . '<i class="fas fa-eye"></i></button>';
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    // Saves the "E. ISS USE ONLY" part of a fully approved VPN request into vpn_iss_details.
    public function hardware_update(VpnIssDetailsRequest $request, $id)
    {
        $vpnForm = VpnForm::with('approver')->findOrFail($id);

        if (!$vpnForm->isFullyApproved()) {
            return response()->json(['message' => 'This request is not fully approved yet.'], 403);
        }

        if (!empty($vpnForm->approver->iss_hardware)) {
            return response()->json(['message' => 'The ISS details were already saved and can no longer be edited.'], 403);
        }

        $details = array_map(fn ($value) => $value ?? '', $request->validated());

        // Prepared By is always the logged-in hardware employee, never taken from the request
        $details['prepared_by'] = $_SESSION['rapidx_name'] ?? '';
        $current = $vpnForm->vpn_iss_details[0] ?? [];

        DB::connection('mysql')->transaction(function () use ($vpnForm, $current, $details) {
            $vpnForm->vpn_iss_details = [array_merge($current, $details)];
            $vpnForm->save();

            // record the hardware employee's part in the approver table
            $approver = $vpnForm->approver;
            $approver->iss_hardware = (string) ($_SESSION['rapidx_user_id'] ?? '');
            $approver->iss_hardware_date = Carbon::now()->toDateString();
            $approver->iss_hardware_remarks = $details['remarks'] !== '' ? $details['remarks'] : null;
            $approver->save();
        });

        return response()->json(['message' => 'Success']);
    }
}