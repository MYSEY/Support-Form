<?php

namespace App\Models;

use App\Models\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}
