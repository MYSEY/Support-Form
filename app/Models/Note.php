<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'notes';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'ticket_id',
        'user_id',
        'message',
        'attachments',
        'created_by',
        'updated_by',
        'deleted_at',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
