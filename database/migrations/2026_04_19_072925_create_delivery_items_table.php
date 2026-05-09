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
    Schema::create('delivery_items', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('delivery_id');
        $table->unsignedBigInteger('item_id');
        $table->integer('quantity');
        $table->timestamps();

        $table->foreign('delivery_id')->references('delivery_id')->on('deliveries')->cascadeOnDelete();
        $table->foreign('item_id')->references('item_id')->on('items')->cascadeOnDelete();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_items');
    }
};
