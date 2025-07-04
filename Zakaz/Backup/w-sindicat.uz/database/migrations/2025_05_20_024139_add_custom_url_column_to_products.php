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
        Schema::table('products', function (Blueprint $table) {
            $table->text('brands')->nullable()->after('images');
            $table->string('custom_url')->nullable()->after('brands');
            $table->text('custom_text')->nullable()->after('custom_url'); // translatable
            $table->boolean('is_available')->default(true)->after('custom_text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['brands', 'custom_url', 'custom_text', 'is_available']);
        });
    }
};
