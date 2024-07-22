<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reply extends Model
{
    use HasFactory;

    protected $table = 'replies';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'name',
        'reply_to',
        'staff_id',
        'message',
        'message_html',
        'dt',
        'attachments',
        'rating',
        'read',
        'created_by',
        'updated_by',
    ];

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
