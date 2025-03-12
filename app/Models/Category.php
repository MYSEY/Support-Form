<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'categories';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'task_id',
        'name',
        'created_by',
        'updated_by',
        'deleted_at',
    ];
}
