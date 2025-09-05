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
        Schema::create('payment_informations', function (Blueprint $table) {
            $table->id();
            $table->string('card_number')->unique();
            $table->string('cvv');
            $table->string('ex_month');
            $table->string('ex_year');
            $table->integer('amount')->default(1000);
            $table->unsignedBigInteger('trainee_id');
            $table->foreign('trainee_id')->references('id')->on('trainees')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_informations');
    }
};
