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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('program_id');
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');

            $table->unsignedBigInteger('advisor_id');
            $table->foreign('advisor_id')->references('id')->on('advisors')->onDelete('cascade');

            $table->date('start_date');
            $table->date('end_date');
            $table->Integer('mark');
            $table->text('description');
            $table->json('related_file')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
