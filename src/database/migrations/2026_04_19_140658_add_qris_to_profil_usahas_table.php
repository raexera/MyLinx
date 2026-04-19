<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profil_usahas', function (Blueprint $table) {

            $table->string('qris_image')->nullable()->after('logo');

            $table->string('qris_merchant_name')->nullable()->after('qris_image');

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
