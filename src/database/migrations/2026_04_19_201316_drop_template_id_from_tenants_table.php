<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            // PostgreSQL: must drop foreign key constraint explicitly before dropping column
            $table->dropForeign(['template_id']);
            $table->dropColumn('template_id');
        });
    }

    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->foreignUuid('template_id')->nullable()->after('slug')->constrained('templates');
        });
    }
};
