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
        Schema::create('advisors', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('education');
            $table->string('address');
            $table->string('city')->nullable();
            $table->enum('language', ['English', 'Arabic','French'])->nullable()->default('english');
            $table->string('cv')->nullable();
            $table->string('certification')->nullable();
            $table->json('otherFile')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->string('password');
            $table->unsignedBigInteger('notification_id')->nullable();
            $table->foreign('notification_id')->references('id')->on('notifications')->onDelete('cascade')->onDelete('set null');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advisors');
    }
};
