<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the database migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add level column to permissions table
        Schema::table('permissions', function (Blueprint $table) {
            $table->unsignedTinyInteger('level')->default(3)->after('guard_name');
        });

        // Add level column to roles table
        Schema::table('roles', function (Blueprint $table) {
            $table->unsignedTinyInteger('level')->default(3)->after('guard_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Remove level column from permissions table
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('level');
        });

        // Remove level column from roles table
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('level');
        });
    }
};
