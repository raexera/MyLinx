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

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'tenant_id',
        'nama_produk',
        'deskripsi',
        'harga',
        'stok',
        'varian_label',
        'varian_opsi',
        'gambar',
        'status',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'harga' => 'decimal:2',
            'stok' => 'integer',
            'status' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Search products by name or description.
     *
     * Usage: Produk::search('batik')->get()
     */
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

    /**
     * Filter products by stock status.
     *
     * Usage: Produk::stockStatus('available')->get()
     */
    public function scopeStockStatus(Builder $query, ?string $status): Builder
    {
        return match ($status) {
            'available' => $query->where('stok', '>', 0)->where('status', true),
            'empty' => $query->where('stok', '<=', 0),
            'inactive' => $query->where('status', false),
            default => $query,
        };
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * A product belongs to one tenant.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * A product can appear in many order items.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Return variant options as a clean array.
     * "Coklat, Stroberi ,Vanila" → ['Coklat', 'Stroberi', 'Vanila']
     */
    public function getVarianOpsiArrayAttribute(): array
    {
        if (empty($this->varian_opsi)) {
            return [];
        }

        return collect(explode(',', $this->varian_opsi))
            ->map(fn ($o) => trim($o))
            ->filter()
            ->values()
            ->all();
    }

    public function hasVariants(): bool
    {
        return ! empty($this->varian_opsi) && count($this->varian_opsi_array) > 0;
    }
}
