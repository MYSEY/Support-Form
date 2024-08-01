<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketHistory extends Model
{
    use HasFactory;

    protected $table = 'ticket_histories';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'trackid',
        'type',
        'from_department_id',
        'to_department_id',
        'from_branch_id',
        'to_branch_id',
        'assignedby',
        'recipient_id',
        'from_status',
        'to_status',
        'from_priority_id',
        'to_priority_id',
        'created_by',
    ];

    public function departmentFrom(){
        return $this->belongsTo(Department::class,'from_department_id');
    }
    public function departmentTo(){
        return $this->belongsTo(Department::class,'to_department_id');
    }
    public function branchFrom(){
        return $this->belongsTo(Branch::class,'from_branch_id');
    }
    public function branchTo(){
        return $this->belongsTo(Branch::class,'to_branch_id');
    }
    public function statusFrom(){
        return $this->belongsTo(CustomStatus::class,'from_status');
    }
    public function statusTo(){
        return $this->belongsTo(CustomStatus::class,'to_status');
    }

    public function assignedBy(){
        return $this->belongsTo(User::class,'assignedby');
    }
    public function recipient(){
        return $this->belongsTo(User::class,'recipient_id');
    }
    public function priorityFrom(){
        return $this->belongsTo(Priority::class,'from_priority_id');
    }
    public function priorityTo(){
        return $this->belongsTo(Priority::class,'to_priority_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
