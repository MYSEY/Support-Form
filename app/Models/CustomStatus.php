<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomStatus extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'custom_statuses';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'name',
        'color',
        'can_customers_change',
        'order',
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
