<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VpnIssDetailsRequest extends FormRequest
{
    /**
     * Only the hardware employees may edit the ISS Use Only section.
     *
     * @return bool
     */
    public function authorize()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return in_array($_SESSION['rapidx_employee_number'] ?? '', config('forms.hardware_employee_numbers'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'vpn_access_status' => ['nullable', 'in:Approved,Rejected'],
            'forticlient_vpn_installed' => ['nullable', 'in:Yes,No,N/A'],
            'fortitoken_mobile_mfa_configured' => ['nullable', 'in:Yes,No,N/A'],
            'vpn_user_account_created' => ['nullable', 'in:Yes,No'],
            'access_restrictions_applied' => ['nullable', 'in:Yes,No'],
            'activation_date' => ['nullable', 'date'],
            'expiration_date' => ['nullable', 'date', 'after_or_equal:activation_date'],
            'remarks' => ['nullable', 'string', 'max:255'],
            'date_completed' => ['nullable', 'date'],
        ];
    }
}
