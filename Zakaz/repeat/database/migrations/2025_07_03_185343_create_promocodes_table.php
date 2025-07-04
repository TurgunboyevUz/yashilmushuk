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
        Schema::create('promocodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->nullable()->constrained()->onDelete('cascade');

            $table->string('code')->unique();
            $table->text('title');
            $table->text('description')->nullable();

            $table->enum('type', ['percentage', 'fixed_amount']);
            $table->decimal('percentage', 10, 2)->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->decimal('coin', 10, 2)->nullable();

            $table->integer('usage_limit')->nullable(); // null = unlimited
            $table->integer('used_count')->default(0);

            $table->datetime('valid_from')->nullable();
            $table->datetime('valid_until')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promocodes');
    }
};
