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

    public function getRouteKeyName(): string
    {

        return parent::getRouteKeyName();
    }

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

    public function scopeStatus(Builder $query, ?string $status): Builder
    {
        if (! $status || $status === 'all') {
            return $query;
        }

        return $query->where('status', $status);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }
}
