<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profil_usahas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('tenant_id')
                  ->constrained('tenants')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
            $table->string('nama_usaha');
            $table->text('deskripsi');
            $table->string('alamat');
            $table->string('no_hp');
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_usahas');
    }
};
