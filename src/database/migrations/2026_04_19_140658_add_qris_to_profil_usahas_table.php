<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profil_usahas', function (Blueprint $table) {
            // Path to uploaded QRIS image (stored on public disk)
            $table->string('qris_image')->nullable()->after('logo');

            // Merchant name extracted from QRIS payload (EMV tag 59)
            $table->string('qris_merchant_name')->nullable()->after('qris_image');

            // National Merchant ID — useful for accountant / reporting
            $table->string('qris_nmid', 50)->nullable()->after('qris_merchant_name');
        });
    }

    public function down(): void
    {
        Schema::table('profil_usahas', function (Blueprint $table) {
            $table->dropColumn(['qris_image', 'qris_merchant_name', 'qris_nmid']);
        });
    }
};
