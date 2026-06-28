<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminAccessRequest extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_APPROVED = 'approved';

    public const STATUS_REJECTED = 'rejected';

    public const STATUS_COMPLETED = 'completed';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'document_number',
        'phone',
        'email',
        'password',
        'verification_code',
        'status',
        'approved_by',
        'approved_at',
        'expires_at',
        'completed_at',
        'rejection_reason',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'approved_at' => 'datetime',
            'expires_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

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

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_APPROVED => 'Aprobada — esperando código',
            self::STATUS_REJECTED => 'Rechazada',
            self::STATUS_COMPLETED => 'Completada',
            default => 'Pendiente de revisión',
        };
    }

    public static function generatePlainCode(): string
    {
        return strtoupper(Str::random(3)).'-'.random_int(100, 999);
    }

    public function storeVerificationCode(string $plainCode): void
    {
        $this->verification_code = Hash::make($plainCode);
        $this->status = self::STATUS_APPROVED;
        $this->approved_at = now();
        $this->expires_at = now()->addHours(24);
    }

    public function verifyCode(string $plainCode): bool
    {
        if (! $this->verification_code) {
            return false;
        }

        return Hash::check($plainCode, $this->verification_code);
    }
}
