<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('menu_item_supplies', function (Blueprint $table) {
    $table->id();

    $table->unsignedBigInteger('menu_id');     // ✅ MUST match menu_items
    $table->unsignedBigInteger('item_id');     // ✅ MUST match items

    $table->integer('quantity_needed');

    $table->timestamps();

    $table->foreign('menu_id')
          ->references('menu_id')
          ->on('menu_items')
          ->onDelete('cascade');

    $table->foreign('item_id')
          ->references('item_id')
          ->on('items')
          ->onDelete('cascade');
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_item_supplies');
    }
};
