<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Services\ACL\{GroupACLService, PersonACLService, SupportACLService, TenantACLService};
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Enums\{Permission, Role, SupportRole};
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

    protected function isSupport(): Attribute
    {
        return Attribute::make(
            get: fn(): bool => $this->role === Role::SUPPORT,
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

    public function hasPermissionTo(Permission $permission): bool
    {
        return match ($this->role) {
            Role::SUPPORT => (function () use ($permission): bool {
                $service = new SupportACLService($this->support->role);
                return $service->hasPermissionTo($permission);
            })(),
            Role::TENANT => app(TenantACLService::class)->hasPermissionTo($permission),
            Role::GROUP => app(GroupACLService::class)->hasPermissionTo($permission),
            default => app(PersonACLService::class)->hasPermissionTo($permission),
        };
    }

    public function support(): HasOne
    {
        return $this->hasOne(Support::class);
    }
}
