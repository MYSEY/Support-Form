<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function getPermissions()
    {
        return DB::table('permissions')
            ->where('permission_category_id', $this->id) // Assuming 'permission_category_id' is the foreign key in 'permissions' table
            ->get();
    }
}
