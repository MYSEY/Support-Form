<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketGuideline extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'ticket_guidelines';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'title',
        'remark',
        'department_id',
        'branch_id',
        'attachments',
        'created_by',
        'updated_by',
        'deleted_at'
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
