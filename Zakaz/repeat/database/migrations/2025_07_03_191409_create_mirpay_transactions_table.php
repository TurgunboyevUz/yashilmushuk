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
        Schema::create('mirpay_transactions', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('payable');
            $table->string('transaction_id');
            $table->bigInteger('amount');
            $table->integer('state');

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('promocode_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('discount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mirpay_transactions');
    }
};
