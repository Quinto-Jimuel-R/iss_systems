<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VpnForm extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'vpn_forms';

    protected $fillable = [
        'control_no',
        'emp_no',
        'name',
        'department_section',
        'position',
        'type_of_request',
        'purpose',
        'date_from',
        'date_to',
        'access_location',
        'device_name',
        'asset_tag',
        'vpn_iss_details',
        'status'
    ];

    protected $casts = [
        'vpn_iss_details' => 'array',
    ];

    public function approver()
    {
        return $this->hasOne(FormApprover::class, 'fk_control_no', 'id')->where('form_type', 'VPN');
    }

    // approved (status 2) by the ISS Manager, Assistant Vice President and President
    public function isFullyApproved()
    {
        $approver = $this->approver;

        return $approver
            && (int) $approver->iss_manager_approval_status === 2
            && (int) $approver->admin_avp_approval_status === 2
            && (int) $approver->admin_president_approval_status === 2;
    }
}