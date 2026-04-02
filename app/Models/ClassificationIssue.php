<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassificationIssue extends Model
{
    use HasFactory;
    protected $table = 'classification_issues';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'department_id',
        'branch_id',
        'name',
        'color',
        'created_by',
        'updated_by',
        'deleted_at',
    ];
}
