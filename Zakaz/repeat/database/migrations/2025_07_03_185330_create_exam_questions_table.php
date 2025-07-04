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
        Schema::create('exam_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained()->onDelete('cascade');
            $table->foreignId('exam_part_id')->constrained()->onDelete('cascade');

            $table->text('question')->nullable(); // question
            $table->text('argument_list')->nullable();

            $table->text('images')->nullable(); // json

            $table->integer('preparation_time')->nullable();
            $table->integer('answer_time')->nullable();

            $table->timestamps();

            $table->index(['exam_id', 'exam_part_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_questions');
    }
};
