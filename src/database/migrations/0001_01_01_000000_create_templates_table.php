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
        Schema::create('templates', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_template');
            $table->string('slug_key')->unique();   // e.g. 'minimalist', 'bold-retail', 'warm-fnb'
            $table->string('kategori');             // e-commerce | portfolio | fnb | retail
            $table->string('preview_url')->nullable();  // URL gambar preview (unsplash dll)
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
