<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminAccessRequest extends Model
{
    protected $table = 'admin_access_requests';

    protected $fillable = [
        'name',
        'document_number',
        'phone',
        'email',
        'password',
        'status',
        'verification_code',
        'approved_by',
        'approved_at',
        'expires_at',
        'rejection_reason',
        'completed_at',
        'permissions',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'expires_at' => 'datetime',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'permissions' => 'array',
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_COMPLETED = 'completed';

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    public static function generatePlainCode(): string
    {
        return strtoupper(Str::random(3)).'-'.random_int(100, 999);
    }

    public function storeVerificationCode(string $plainCode): void
    {
        $this->verification_code = Hash::make(trim($plainCode));
        $this->status = self::STATUS_APPROVED;
        $this->approved_at = now();
        $this->expires_at = now()->addHours(24);
        $this->save();
    }

    public function verifyCode(string $plainCode): bool
    {
        if (! $this->verification_code) {
            return false;
        }

        return Hash::check(trim($plainCode), $this->verification_code);
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_APPROVED => 'Aprobada - esperando activación',
            self::STATUS_REJECTED => 'Rechazada',
            self::STATUS_COMPLETED => 'Completada',
            default => 'Pendiente de revisión',
        };
    }
}

