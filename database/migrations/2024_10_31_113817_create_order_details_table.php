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
        Schema::create('order_details', function (Blueprint $table) {
            $table->foreignId('order_id')
                ->constrained('orders', 'id')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('book_id')
                ->constrained('books', 'id')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            $table->unsignedInteger('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('subtotal', 15, 2)
                ->storedAs('unit_price * quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
