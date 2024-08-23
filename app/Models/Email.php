<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;
    protected $table = 'mails';
    protected $guarded = ['id'];
    protected $fillable = [
        'id',
        'from',
        'to',
        'subject',
        'message',
        'created_by',
        'updated_by',
        'deleted_at',
    ];
}
