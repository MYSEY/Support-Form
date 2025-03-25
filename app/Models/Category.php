<?php

namespace App\Models;

use App\Models\CategoryTask;
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
        'name',
        'created_by',
        'updated_by',
        'deleted_at',
    ];

    public function categoryTasks()
    {
        return $this->hasMany(CategoryTask::class, 'category_id');
    }
}
