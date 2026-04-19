<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfilUsaha extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'profil_usahas';

    protected $fillable = [
        'tenant_id',
        'nama_usaha',
        'deskripsi',
        'alamat',
        'no_hp',
        'logo',
        'qris_image',
        'qris_merchant_name',
        'qris_nmid',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
