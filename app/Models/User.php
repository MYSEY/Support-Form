<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'user',
        'name',
        'email',
        'profile',
        'email_verified_at',
        'password',
        'department_id',
        'branch_id',
        'signature',
        'afterreply',
        'autostart',
        'autoreload',
        'secmin',
        'notify_customer_new',
        'notify_customer_reply',
        'show_suggested',
        'notify_new_unassigned',
        'notify_new_my',
        'notify_reply_unassigned',
        'notify_reply_my',
        'notify_assigned',
        'notify_pm',
        'notify_note',
        'notify_overdue_unassigned',
        'notify_overdue_my',
        'autoassign',
        'rating',
        'status',
        'created_by',
        'updated_by',
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class ,'updated_by');
    }
    public function role(){
        return $this->belongsTo(Role::class,'role_id');
    }
    public function department(){
        return $this->belongsTo(Department::class,'department_id');
    }
    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id');
    }


    public function getRolePermissionAttribute(){
        return optional($this->role)->role_type;
    }
    public function getRoleNameAttribute(){
        return optional($this->role)->name;
    }
    public function getDepartmentNameAttribute(){
        return optional($this->department)->name_english;
    }
    public function getBranchNameAttribute(){
        return optional($this->branch)->branch_name_en;
    }

    public function isUserOnline(){
        return Cache::has('user-is-online-'.$this->id);
    }
}
