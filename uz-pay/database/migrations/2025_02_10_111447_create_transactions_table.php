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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction');
            $table->morphs('transactionable'); // transaction owner

            $table->bigInteger('amount');
            $table->longText('details');
            $table->integer('state');
            
            $table->string('cancel_reason')->nullable();
            $table->string('cancel_time')->nullable();

            $table->string('create_time');
            $table->string('perform_time')->nullable();
            $table->string('payment_time')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
