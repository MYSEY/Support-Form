<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResponsesTicket extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'responses_tickets';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'title',
        'message',
        'department_id',
        'branch_id',
        'tpl_order',
        'created_by',
        'updated_by',
        'deleted_at'
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function department(){
        return $this->belongsTo(Department::class,'department_id');
    }
    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id');
    }
}
