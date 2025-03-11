<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'tasks';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'name',
        'description',
        'created_by',
        'updated_by',
        'deleted_at',
    ];
}