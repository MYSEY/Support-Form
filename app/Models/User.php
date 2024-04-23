<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

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
