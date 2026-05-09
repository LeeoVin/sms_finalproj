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
    Schema::create('order_supply_usage', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('order_id');
        $table->unsignedBigInteger('item_id');
        $table->integer('quantity');
        $table->timestamps();

        $table->foreign('order_id')->references('order_id')->on('orders')->cascadeOnDelete();
        $table->foreign('item_id')->references('item_id')->on('items')->cascadeOnDelete();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_supply_usage');
    }
};
