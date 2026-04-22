<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->dropColumn(['varian_label', 'varian_opsi']);
            $table->jsonb('variants')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->string('varian_label', 50)->nullable();
            $table->text('varian_opsi')->nullable();
            $table->dropColumn('variants');
        });
    }
};
