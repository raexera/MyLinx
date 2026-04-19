<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'tenant_id',
        'kode_order',
        'nama_pembeli',
        'email_pembeli',
        'no_hp_pembeli',
        'alamat_pengiriman',
        'catatan_pembeli',
        'total_harga',
        'status',
        'ekspedisi',
        'nomor_resi',
        'shipped_at',
        'public_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'total_harga' => 'decimal:2',
            'shipped_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            if (empty($order->public_token)) {
                $order->public_token = \Illuminate\Support\Str::random(32);
            }
        });
    }

    /**
     * Use public_token for public-facing URLs.
     * This is the route-model-binding column for Route::get('/invoice/{order:public_token}', ...)
     */
    public function getRouteKeyName(): string
    {
        // Default binding uses `id`; we override only on the specific public route below.
        return parent::getRouteKeyName();
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Search orders by order code or buyer name.
     *
     * Usage: Order::search('ORD-2026')->get()
     */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (! $term) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $q->where('kode_order', 'ilike', "%{$term}%")
                ->orWhere('nama_pembeli', 'ilike', "%{$term}%")
                ->orWhere('email_pembeli', 'ilike', "%{$term}%");
        });
    }

    /**
     * Filter orders by status.
     *
     * Usage: Order::status('pending')->get()
     */
    public function scopeStatus(Builder $query, ?string $status): Builder
    {
        if (! $status || $status === 'all') {
            return $query;
        }

        return $query->where('status', $status);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * An order belongs to one tenant.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * An order has many line items.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * An order has one invoice.
     */
    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }
}
