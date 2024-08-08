<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionCategory extends Model
{
    use HasFactory;
    protected $table = 'permission_categories';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
        'deleted_at',
    ];
}
