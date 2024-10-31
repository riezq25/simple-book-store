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
        Schema::create('customers', function (Blueprint $table) {
            $table->id('customer_id');
            $table->foreignId('user_id')
                ->constrained('users');
            $table->string('customer_name', 255);
            $table->string('phone_number', 15);
            $table->string('email', 100)
                ->unique();
            $table->text('address')
                ->nullable();
            $table->date('birth_date');
            $table->char('city_code', 4);
            $table->foreign('city_code')
                ->references('city_code')
                ->on('cities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
