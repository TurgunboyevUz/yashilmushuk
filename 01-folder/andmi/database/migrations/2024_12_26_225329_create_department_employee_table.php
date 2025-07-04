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
        Schema::create('department_employee', function (Blueprint $table) {
            $table->id();

            $table->foreignId('role_id');
            $table->foreignId('department_id');
            $table->foreignId('employee_id');

            $table->string('staff_code')->nullable();
            $table->string('staff_position')->nullable();

            $table->string('employee_code')->nullable();
            $table->string('employee_type')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department_employee');
    }
};
