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
    Schema::create('deliveries', function (Blueprint $table) {
        $table->id('delivery_id');
        $table->unsignedBigInteger('supplier_id');
        $table->string('branch');
        $table->date('delivery_date');
        $table->string('status')->default('pending'); // pending / confirmed
        $table->timestamps();

        $table->foreign('supplier_id')->references('supplier_id')->on('suppliers')->cascadeOnDelete();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
