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
        Schema::create('items', function (Blueprint $table) {
    $table->id('item_id');

    $table->foreignId('supplier_id')
          ->constrained('suppliers', 'supplier_id')
          ->onDelete('cascade');
    
    $table->string('item_name');
    $table->string('status');
    $table->integer('count');
    $table->string('category')->nullable();
    $table->decimal('price', 10, 2)->nullable();
    $table->timestamps();
    
    
    
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
