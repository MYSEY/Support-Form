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
        'token_expries',
        'dt',
        'tmp',
    ];

    public function userOnline()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
