<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Role;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'role',
        'name',
        'email',
        'password',
        'profile_photo'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'role' => Role::class,
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected function isMainSupport(): Attribute
    {
        return Attribute::make(
            get: fn(): bool => $this->role === Role::MAIN_SUPPORT,
        );
    }

    protected function isManagerSupport(): Attribute
    {
        return Attribute::make(
            get: fn(): bool => $this->role === Role::MANAGER_SUPPORT,
        );
    }

    protected function isTenant(): Attribute
    {
        return Attribute::make(
            get: fn(): bool => $this->role === Role::TENANT,
        );
    }

    protected function isGroup(): Attribute
    {
        return Attribute::make(
            get: fn(): bool => $this->role === Role::GROUP,
        );
    }

    protected function isPerson(): Attribute
    {
        return Attribute::make(
            get: fn(): bool => $this->role === Role::PERSON,
        );
    }
}
