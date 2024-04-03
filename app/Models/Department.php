<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    
    protected $table = 'departments';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'name_khmer',
        'name_english',
        'parent_id',
        'head_department',
        'created_by',
        'updated_by',
        'deleted_at',
    ];
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function upldatedBy()
    {
        return $this->belongsTo(User::class ,'updated_by');
    }
}
