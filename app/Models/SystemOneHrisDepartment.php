<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemOneHrisDepartment extends Model
{
    use HasFactory;

    protected $connection = 'mysql_systemone';
    protected $table = 'tbl_Department';

    public function systemone_division_info()
    {
        return $this->hasOne(SystemOneHrisDivision::class, 'pkid', 'fkDivision')->where('logdel', 0);
    }
}