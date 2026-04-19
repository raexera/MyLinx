<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // What the buyer selected at checkout ("Coklat", "Size L", etc.)
            // Free-text because we don't maintain variant stock or pricing.
            $table->string('varian', 100)->nullable()->after('jumlah');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('varian');
        });
    }
};
