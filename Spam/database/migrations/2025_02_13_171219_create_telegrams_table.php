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
        Schema::create('telegrams', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('api_id');
            $table->string('api_hash');
            $table->string('phone');

            $table->string('session_path');

            $table->timestamp('last_send_message_at')->nullable();
            $table->timestamp('start_send_message_at')->nullable();
            $table->integer('today_send_message_count')->default(0);

            $table->integer('active')->default(false); //0 - inactive, 1 - active, 2 - spammed

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegrams');
    }
};
