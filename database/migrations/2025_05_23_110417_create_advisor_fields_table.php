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
        Schema::create('advisor_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('advisor_id');
            $table->unsignedBigInteger('field_id');
            $table->foreign('advisor_id')->references('id')->on('advisors')->onDelete('cascade');
            $table->foreign('field_id')->references('id')->on('fields')->onDelete('cascade');
            $table->enum('status',['accept','not-accept'])->default('not-accept');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advisor_fields');
    }
};
