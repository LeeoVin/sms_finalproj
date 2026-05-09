<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branch_items', function (Blueprint $table) {
            $table->id();

            // branch name (since your system uses text-based branches)
            $table->string('branch');

            // link to items table
            $table->unsignedBigInteger('item_id');

            // stock per branch
            $table->integer('stock')->default(0);

            $table->timestamps();

            // foreign key constraint
            $table->foreign('item_id')
                  ->references('item_id')
                  ->on('items')
                  ->onDelete('cascade');

            // optional: prevent duplicate item per branch
            $table->unique(['branch', 'item_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branch_items');
    }
};

