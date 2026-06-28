<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'delivery_type',
        'address_neighborhood',
        'address_main_street',
        'address_secondary_street',
        'address_reference',
        'subtotal',
        'total',
        'status',
        'whatsapp_sent_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'total' => 'decimal:2',
            'whatsapp_sent_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateOrderNumber(): string
    {
        $lastId = static::query()->max('id') ?? 0;

        return 'SC-'.str_pad((string) ($lastId + 1), 4, '0', STR_PAD_LEFT);
    }

    public function deliveryLabel(): string
    {
        return $this->delivery_type === 'llevar'
            ? 'Para Llevar / Delivery'
            : 'Consumo Local';
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'sent' => 'Enviado',
            'completed' => 'Completado',
            'cancelled' => 'Cancelado',
            default => 'Pendiente',
        };
    }
}
