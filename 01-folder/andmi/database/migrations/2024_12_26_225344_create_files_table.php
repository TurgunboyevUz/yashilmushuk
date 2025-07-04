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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('name');
            $table->string('path');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size');
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->string('type')->nullable();
            $table->nullableMorphs('fileable');

            $table->foreignId('education_year_id')->nullable()->constrained('education_years')->cascadeOnDelete();

            $table->integer('student_score')->default(0);
            $table->integer('teacher_score')->default(0);

            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->unsignedBigInteger('inspector_id')->nullable();

            $table->text('reject_reason')->nullable();
            $table->unsignedBigInteger('rejected_by')->nullable();

            $table->enum('status', ['pending', 'reviewed', 'approved', 'rejected'])->default('pending');

            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();

            $table->timestamps();

            $table->foreign('teacher_id')->references('id')->on('users');
            $table->foreign('inspector_id')->references('id')->on('users');
            $table->foreign('rejected_by')->references('id')->on('users');
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
