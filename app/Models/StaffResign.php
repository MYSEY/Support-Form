<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffResign extends Model
{
    protected $connection = 'mysqlhrconnection';
    protected $table = 'staff_resign';
}
