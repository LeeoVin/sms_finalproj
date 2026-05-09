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
    Schema::create('sales', function (Blueprint $table) {
        $table->id();

        // what was sold
        $table->foreignId('menu_id')->constrained('menu_items', 'menu_id');

        // quantity sold
        $table->integer('quantity');

        // price per item (snapshot at time of sale)
        $table->decimal('price', 10, 2);

        // total amount (quantity * price)
        $table->decimal('total', 10, 2);

        // optional: branch tracking
        $table->string('branch')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
