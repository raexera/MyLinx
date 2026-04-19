<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Buyer contact (required for WhatsApp flow)
            $table->string('no_hp_pembeli', 30)->nullable()->after('email_pembeli');

            // Shipping info
            $table->text('alamat_pengiriman')->nullable()->after('no_hp_pembeli');
            $table->text('catatan_pembeli')->nullable()->after('alamat_pengiriman');

            // Fulfillment (filled when seller ships the package)
            $table->string('ekspedisi', 50)->nullable()->after('status');
            $table->string('nomor_resi', 100)->nullable()->after('ekspedisi');
            $table->timestamp('shipped_at')->nullable()->after('nomor_resi');

            // Public token for invoice URL (unguessable — used in WA-shared invoice link)
            $table->string('public_token', 32)->nullable()->unique()->after('id');
        });

        // Backfill public_token for existing orders
        DB::table('orders')->whereNull('public_token')->orderBy('id')->chunkById(100, function ($orders) {
            foreach ($orders as $order) {
                DB::table('orders')
                    ->where('id', $order->id)
                    ->update(['public_token' => Str::random(32)]);
            }
        });

        // Once backfilled, make it NOT NULL
        Schema::table('orders', function (Blueprint $table) {
            $table->string('public_token', 32)->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'no_hp_pembeli',
                'alamat_pengiriman',
                'catatan_pembeli',
                'ekspedisi',
                'nomor_resi',
                'shipped_at',
                'public_token',
            ]);
        });
    }
};
