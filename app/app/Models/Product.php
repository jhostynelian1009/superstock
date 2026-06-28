<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Product extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'image',
        'stock',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Alias usado por las vistas públicas del catálogo.
     */
    public function getImagePathAttribute(): ?string
    {
        return $this->image;
    }

    /**
     * Estado legible para el catálogo público (active / inactive).
     */
    public function getStatusAttribute(): string
    {
        return $this->is_active ? 'active' : 'inactive';
    }

    protected static function booted(): void
    {
        static::saving(function (Product $product): void {
            if (blank($product->slug) && filled($product->name)) {
                $product->slug = static::uniqueSlug(Str::slug($product->name), $product->id);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock(Builder $query): Builder
    {
        return $query->where('stock', '>', 0);
    }

    public static function uniqueSlug(string $baseSlug, ?int $ignoreId = null): string
    {
        $slug = $baseSlug;
        $counter = 1;

        while (static::query()
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
