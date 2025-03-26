<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $table = 'maintenances';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'asset_id',
        'maintenance_date',
        'maintenace_by',
        'description',
        'created_by',
        'updated_by',
        'deleted_at',
    ];
}
