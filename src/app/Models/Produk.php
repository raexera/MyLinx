<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'tenant_id',
        'nama_produk',
        'deskripsi',
        'harga',
        'stok',
        'variants',
        'gambar',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'harga' => 'decimal:2',
            'stok' => 'integer',
            'status' => 'boolean',
            'variants' => 'array',
        ];
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (! $term) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $q->where('nama_produk', 'ilike', "%{$term}%")
                ->orWhere('deskripsi', 'ilike', "%{$term}%");
        });
    }

    public function scopeStockStatus(Builder $query, ?string $status): Builder
    {
        return match ($status) {
            'available' => $query->where('stok', '>', 0)->where('status', true),
            'empty' => $query->where('stok', '<=', 0),
            'inactive' => $query->where('status', false),
            default => $query,
        };
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function hasVariants(): bool
    {
        return ! empty($this->variants) && is_array($this->variants) && count($this->variants) > 0;
    }
}
