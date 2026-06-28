<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    protected static function booted(): void
    {
        static::saving(function (Category $category): void {
            if (blank($category->slug) && filled($category->name)) {
                $category->slug = static::uniqueSlug(Str::slug($category->name), $category->id);
            }
        });
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
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
