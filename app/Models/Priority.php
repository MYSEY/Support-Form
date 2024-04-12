<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Priority extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'priorities';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'name',
        'color',
        'created_by',
        'updated_by',
        'deleted_at',
    ];
}
