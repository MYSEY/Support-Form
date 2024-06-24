<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'name',
        'email',
        'trackid',
        'department_id',
        'branch_id',
        'priority',
        'subject',
        'message',
        'message_html',
        'dt',
        'lastchange',
        'firstreply',
        'closedat',
        'articles',
        'ip',
        'language',
        'status',
        'openedby',
        'firstreplyby',
        'closedby',
        'replies',
        'staffreplies',
        'owner',
        'assignedby',
        'time_worked',
        'lastreplier',
        'replierid',
        'archive',
        'locked',
        'attachments',
        'merged',
        'history',
        'due_date',
        'overdue_email_sent',
        'satisfaction_email_sent',
        'satisfaction_email_dt',
        'issue_type',
        'created_by',
        'updated_by',
        'deleted_at',
    ];

    public function department(){
        return $this->belongsTo(Department::class,'department_id');
    }
    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id');
    }
    public function assignedby(){
        return $this->belongsTo(User::class,'assignedby');
    }
    public function priorities(){
        return $this->belongsTo(Priority::class,'priority');
    }


    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function upldatedBy()
    {
        return $this->belongsTo(User::class ,'updated_by');
    }
}
