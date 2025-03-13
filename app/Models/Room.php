<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'rooms';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
        'deleted_at',
    ];
}
