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
        Schema::create('training_programs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trainee_id');
            $table->unsignedBigInteger('program_id');
            $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->boolean('send_email')->default(0);
            $table->foreign('trainee_id')->references('id')->on('trainees')->onDelete('cascade');
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_programs');
    }
};
