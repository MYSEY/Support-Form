<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IssueType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'issue_types';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'name',
        'type',
        'req',
        'category_type',
        'department_id',
        'branch_id',
        'classification',
        'value',
        'created_by',
        'updated_by',
        'deleted_at',
    ];
    public function department(){
        return $this->belongsTo(Department::class,'department_id');
    }
    public function Classification(){
        return $this->belongsTo(ClassificationIssue::class,'classification');
    }
}
