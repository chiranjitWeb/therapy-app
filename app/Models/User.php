<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Laratrust\Traits\HasRolesAndPermissions; //  correct trait
use Laratrust\Contracts\LaratrustUser;       //  interface
use App\Mail\CustomResetPassword;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable implements LaratrustUser
{
    use HasFactory, Notifiable, HasRolesAndPermissions; //  attach trait

    protected $fillable = [
        'name', 'email', 'password',
        'first_name', 'last_name', 'addiction_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function addiction(): BelongsTo
    {
        return $this->belongsTo(Addiction::class);
    }

    public function availabilities(): HasMany
    {
        return $this->hasMany(Availability::class, 'therapist_id');
    }

    public function meetings(): HasMany
    {
        return $this->hasMany(Meeting::class, 'user_id');
    }
    public function sendPasswordResetNotification($token)
    {
        \Mail::to($this->email)->send(new CustomResetPassword($token, $this->email));
    }
}
