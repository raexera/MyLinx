<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produks', function (Blueprint $table) {

            $table->string('varian_label', 50)->nullable()->after('stok');

            $table->text('varian_opsi')->nullable()->after('varian_label');
        });
    }

    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->dropColumn(['varian_label', 'varian_opsi']);
        });
    }
};
