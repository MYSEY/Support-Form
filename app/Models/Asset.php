<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asset extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'assets';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'category_id',
        'office',
        'location',
        'end_user',
        'serial',
        'device_name',
        'lifecycle_month',
        'created_by',
        'updated_by',
        'deleted_at',
    ];
}
