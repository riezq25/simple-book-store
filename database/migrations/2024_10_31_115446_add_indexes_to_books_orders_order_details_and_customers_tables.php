<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToBooksOrdersOrderDetailsAndCustomersTables extends Migration
{
    public function up()
    {
        // Tabel books
        Schema::table('books', function (Blueprint $table) {
            $table->index('title'); // Index pada kolom title
        });

        // Tabel orders
        Schema::table('orders', function (Blueprint $table) {
            $table->index('customer_id'); // Index pada kolom customer_id
            $table->index('order_date');  // Index pada kolom order_date
        });

        // Tabel order_details
        Schema::table('order_details', function (Blueprint $table) {
            $table->index('order_id'); // Index pada kolom order_id
            $table->index('book_id');  // Index pada kolom book_id
        });

        // Tabel customers
        Schema::table('customers', function (Blueprint $table) {
            $table->index('user_id');   // Index pada kolom user_id
            $table->index('city_code'); // Index pada kolom city_code
        });
    }

    public function down()
    {
        // Menghapus index pada masing-masing tabel
        Schema::table('books', function (Blueprint $table) {
            $table->dropIndex(['title']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['customer_id']);
            $table->dropIndex(['order_date']);
        });

        Schema::table('order_details', function (Blueprint $table) {
            $table->dropIndex(['order_id']);
            $table->dropIndex(['book_id']);
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['city_code']);
        });
    }
}
