<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Online extends Model
{
    use HasFactory;
    protected $table = 'onlines';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'user_id',
        'dt',
        'tmp',
    ];
}
