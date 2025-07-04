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
        Schema::create('buttons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained();

            $table->string('label');
            $table->string('value');

            $table->string('subscribed_text')->nullable();
            $table->string('unsubscribed_text')->nullable();

            $table->integer('type')->default(1); // 1 - subscribe, 2 - url
            $table->text('position')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buttons');
    }
};
