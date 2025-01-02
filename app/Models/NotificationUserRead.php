<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationUserRead extends Model
{
    use HasFactory;
    protected $table = 'notification_user_reads';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'notification_id',
        'user_id',
    ];
}
