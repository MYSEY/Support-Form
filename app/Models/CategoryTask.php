<?php

namespace App\Models;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryTask extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'category_tasks';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'category_id',
        'task_id',
        'created_by',
        'updated_by',
        'deleted_at',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}
