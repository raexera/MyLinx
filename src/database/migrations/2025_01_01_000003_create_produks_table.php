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
        Schema::create('produks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('tenant_id')
                  ->constrained('tenants')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
            $table->string('nama_produk');
            $table->text('deskripsi');
            $table->decimal('harga', 12, 2);
            $table->integer('stok')->default(0);
            $table->string('gambar')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
