<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared(
            'DROP PROCEDURE IF EXISTS CreateOrder;'
        );

        DB::unprepared("
        CREATE PROCEDURE CreateOrder(
    IN p_customer_id INT,
    IN p_order_date DATE,
    IN p_order_details JSON
)
BEGIN
    DECLARE v_order_id INT;
    DECLARE v_invoice_number VARCHAR(20);
    DECLARE v_total DECIMAL(10,2) DEFAULT 0;
    DECLARE i INT DEFAULT 0;
    DECLARE detail_count INT DEFAULT JSON_LENGTH(p_order_details);
    DECLARE v_book_id INT;
    DECLARE v_quantity INT;
    DECLARE v_unit_price DECIMAL(10,2);
    DECLARE v_subtotal DECIMAL(10,2);

    -- Blok pengecualian error handler
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        -- Jika ada error, rollback semua perubahan
        ROLLBACK;
    END;

    -- Mulai transaksi
    START TRANSACTION;

    -- Generate invoice number
    SET v_invoice_number = CONCAT('INV-', DATE_FORMAT(p_order_date, '%Y%m%d'), LPAD((SELECT COUNT(*) + 1 FROM orders WHERE DATE(order_date) = p_order_date), 4, '0'));

    -- Insert new order
    INSERT INTO orders (invoice_number, order_date, customer_id, total, created_at, updated_at)
    VALUES (v_invoice_number, p_order_date, p_customer_id, 0, NOW(), NOW());

    SET v_order_id = LAST_INSERT_ID();

    -- Process each order detail
    WHILE i < detail_count DO
        SET v_book_id = JSON_UNQUOTE(JSON_EXTRACT(p_order_details, CONCAT('$[', i, '].book_id')));
        SET v_quantity = JSON_UNQUOTE(JSON_EXTRACT(p_order_details, CONCAT('$[', i, '].quantity')));
        SET v_unit_price = (SELECT price FROM books WHERE id = v_book_id);
        SET v_subtotal = v_quantity * v_unit_price;

        INSERT INTO order_details (order_id, book_id, quantity, unit_price, created_at, updated_at)
        VALUES (v_order_id, v_book_id, v_quantity, v_unit_price, NOW(), NOW());

        SET v_total = v_total + v_subtotal;

        SET i = i + 1;
    END WHILE;

    -- Update total in orders
    UPDATE orders SET total = v_total WHERE id = v_order_id;

    -- Commit transaksi jika tidak ada error
    COMMIT;
END;

");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared(
            'DROP PROCEDURE IF EXISTS CreateOrder;'
        );
    }
};
