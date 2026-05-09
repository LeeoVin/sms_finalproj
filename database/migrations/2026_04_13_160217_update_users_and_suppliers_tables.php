<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // ADD branch to users
        Schema::table('users', function (Blueprint $table) {
            $table->string('branch')->after('role');
        });

        // REMOVE branch from suppliers
        Schema::table('suppliers', function (Blueprint $table) {
            if (Schema::hasColumn('suppliers', 'branch')) {
                $table->dropColumn('branch');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('branch');
        });

        Schema::table('suppliers', function (Blueprint $table) {
            $table->string('branch')->nullable();
        });
    }
};