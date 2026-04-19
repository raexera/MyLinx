<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tenant extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'nama_tenant',
        'slug',
        'status',
        'customization',
        'page_views',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
            'customization' => 'array',
            'page_views' => 'integer',
        ];
    }

    public function getCustomizationWithDefaultsAttribute(): array
    {
        return array_merge([
            'accent_color' => '#2E5136',
            'background_color' => '#FBFBF9',
            'content_order' => 'products_first',
            'product_layout' => 'grid',
            'hero_style' => 'banner',
        ], $this->customization ?? []);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function profilUsaha(): HasOne
    {
        return $this->hasOne(ProfilUsaha::class);
    }

    public function portofolios(): HasMany
    {
        return $this->hasMany(Portofolio::class);
    }

    public function produks(): HasMany
    {
        return $this->hasMany(Produk::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
