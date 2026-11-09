<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemOneHrisEmployeeInfo extends Model
{
    use HasFactory;

    protected $connection = 'mysql_systemone';
    protected $table = 'tbl_EmployeeInfo';

    public function department_info(){
        return $this->hasOne(SystemOneHrisDepartment::class, 'pkid', 'fkDepartment');
    }

    public function position_info(){
        return $this->hasOne(SystemOneHrisPosition::class, 'pkid', 'fkPosition');
    }

    public function section_info(){
        return $this->hasOne(SystemOneHrisSection::class, 'pkid', 'fkSection');
    }

    public function division_info(){
        return $this->hasOne(SystemOneHrisDivision::class, 'pkid', 'fkDivision');
    }
}