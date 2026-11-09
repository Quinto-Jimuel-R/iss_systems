<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemOneHrisPosition extends Model
{
    use HasFactory;

    protected $connection = 'mysql_systemone';
    protected $table = 'tbl_Position';
}