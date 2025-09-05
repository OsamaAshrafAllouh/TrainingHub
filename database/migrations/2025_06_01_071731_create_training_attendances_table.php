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
        Schema::create('training_attendances', function (Blueprint $table) {
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('trainee_id');
            $table->enum('status', ['present', 'absent']);
            $table->date('date');
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
            $table->foreign('trainee_id')->references('id')->on('trainees')->onDelete('cascade');
            $table->primary(['program_id', 'trainee_id']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_attendances');
    }
};
