<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profil_usahas', function (Blueprint $table) {
            // Kita hapus kolom lama, dan buat 1 kolom JSON sakti
            $table->dropColumn(['nama_bank', 'nomor_rekening', 'atas_nama_rekening']);
            $table->json('rekening_banks')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('profil_usahas', function (Blueprint $table) {
            $table->string('nama_bank', 50)->nullable();
            $table->string('nomor_rekening', 50)->nullable();
            $table->string('atas_nama_rekening', 100)->nullable();
            $table->dropColumn('rekening_banks');
        });
    }
};
