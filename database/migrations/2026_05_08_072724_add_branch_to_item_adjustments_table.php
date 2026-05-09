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
    if (!Schema::hasColumn('item_adjustments', 'branch')) {
        Schema::table('item_adjustments', function (Blueprint $table) {
            $table->string('branch')->nullable();
        });
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_adjustments', function (Blueprint $table) {
            //
        });
    }
};
