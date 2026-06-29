<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    public const ROLE_ADMIN    = 'Administrador';
    public const ROLE_EMPLOYEE = 'Empleado';

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'document_number',
        'phone',
        'email',
        'password',
        'role',
        'is_active',
        'is_primary_admin',
        'permissions',
    ];

    /**
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
            'is_primary_admin'  => 'boolean',
            'permissions'       => 'array',
        ];
    }

    public function inventoryMovements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isEmployee(): bool
    {
        return $this->role === self::ROLE_EMPLOYEE;
    }

    public function isPrimaryAdmin(): bool
    {
        return $this->isAdmin() && $this->is_primary_admin;
    }

    public function hasPermissionTo(string $module): bool
    {
        if ($this->isPrimaryAdmin()) {
            return true;
        }

        if (is_null($this->permissions)) {
            return true;
        }

        return in_array($module, $this->permissions);
    }
}
