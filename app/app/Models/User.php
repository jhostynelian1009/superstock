<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    public const ROLE_ADMIN = 'Administrador';
    public const ROLE_EMPLOYEE = 'Empleado';
    public const ROLE_CLIENT = 'Cliente';

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
        'default_delivery_type',
        'address_neighborhood',
        'address_main_street',
        'address_secondary_street',
        'address_reference',
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
            'password' => 'hashed',
            'is_active' => 'boolean',
            'is_primary_admin' => 'boolean',
        ];
    }

    public function inventoryMovements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isEmployee(): bool
    {
        return $this->role === self::ROLE_EMPLOYEE;
    }

    public function isClient(): bool
    {
        return $this->role === self::ROLE_CLIENT;
    }

    public function isPrimaryAdmin(): bool
    {
        return $this->isAdmin() && $this->is_primary_admin;
    }

    public function hasSavedDeliveryAddress(): bool
    {
        return $this->default_delivery_type === 'llevar'
            && filled($this->address_neighborhood)
            && filled($this->address_main_street)
            && filled($this->address_secondary_street)
            && filled($this->address_reference);
    }

    public function deliveryLabel(): string
    {
        return $this->default_delivery_type === 'llevar'
            ? 'Para Llevar / Delivery'
            : 'Consumo Local';
    }
}
