<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceDetail extends Model
{
    use HasFactory;
    protected $table = 'maintenance_details';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'maintenance_id',
        'task_id',
        'note',
        'created_by',
        'updated_by',
        'deleted_at',
    ];
}
