<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormApprover extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'form_approver';

    protected $fillable = [
        'fk_control_no',
        'form_type',
        'iss_manager',
        'iss_manager_date',
        'iss_manager_remarks',
        'admin_avp',
        'admin_avp_date',
        'admin_avp_remarks',
        'admin_president',
        'admin_president_date',
        'admin_president_remarks',
        'iss_hardware',
        'iss_hardware_date',
        'iss_hardware_remarks'
    ];
}