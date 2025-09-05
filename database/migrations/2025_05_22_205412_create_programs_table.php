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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('name');
            $table->string('hours');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('type', ['free', 'paid'])->default('free');
            $table->integer('price')->nullable();
            $table->integer('number');
            $table->enum('duration', ['days', 'weeks', 'months','years'])->default('days');
            $table->enum('level', ['beginner', 'intermediate', 'advanced']);
            $table->enum('language', ['English', 'Arabic','French'])->default('english');
            $table->unsignedBigInteger('field_id');
            $table->foreign('field_id')->references('id')->on('fields')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('advisor_id');
            $table->foreign('advisor_id')->references('id')->on('advisors')->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
