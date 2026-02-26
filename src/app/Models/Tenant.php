<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tenant extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nama_tenant',
        'slug',
        'template_id',
        'status',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * A tenant uses one template.
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    /**
     * A tenant has many users (tenant admins, staff, etc.).
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * A tenant has one business profile.
     */
    public function profilUsaha(): HasOne
    {
        return $this->hasOne(ProfilUsaha::class);
    }

    /**
     * A tenant has many portfolio entries.
     */
    public function portofolios(): HasMany
    {
        return $this->hasMany(Portofolio::class);
    }

    /**
     * A tenant has many products.
     */
    public function produks(): HasMany
    {
        return $this->hasMany(Produk::class);
    }

    /**
     * A tenant has many orders.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Route Model Binding
    |--------------------------------------------------------------------------
    */

    /**
     * Resolve route model binding by slug instead of UUID.
     * Enables: mylinx.com/{tenant_slug}
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
