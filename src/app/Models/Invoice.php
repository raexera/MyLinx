<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'order_id',
        'nomor_invoice',
        'qr_code_url',
        'status_pembayaran',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
