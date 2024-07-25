<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        'user',
        'name',
        'email',
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
}
