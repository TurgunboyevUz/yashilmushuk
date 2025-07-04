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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['speaking', 'writing']);

            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image');

            $table->boolean('is_free')->default(false);
            $table->integer('price_uzs')->nullable();
            $table->integer('price_coin')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
