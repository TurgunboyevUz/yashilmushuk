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
        Schema::create('forums', function (Blueprint $table) {
            $table->id();

            $table->string('tele_id')->nullable();

            $table->string('title');
            $table->string('username')->nullable();

            $table->text('link')->nullable();

            $table->boolean('by_username')->default(false);
            $table->boolean('invitable')->default(false);
            $table->boolean('is_telegram')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forums');
    }
};
