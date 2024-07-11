<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
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
}
