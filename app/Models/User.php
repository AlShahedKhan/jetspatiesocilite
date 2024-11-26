<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Permission;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, HasProfilePhoto, HasTeams, Notifiable, TwoFactorAuthenticatable, HasRoles;

    protected $guard_name = 'sanctum';

    protected $fillable = [
        'name',
        'email',
        'password',
        'provider_id',
        'provider_name'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Define the permissions relationship.
     */
    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'model_has_permissions',
            'model_id',
            'permission_id'
        )->where('model_type', self::class);
    }
}
