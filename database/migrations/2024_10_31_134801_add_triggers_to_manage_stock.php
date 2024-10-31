<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddTriggersToManageStock extends Migration
{
    public function up()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_order_details_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS after_order_details_update');
        DB::unprepared('DROP TRIGGER IF EXISTS after_order_details_delete');

        // Trigger to decrease stock on insert
        DB::unprepared('
            CREATE TRIGGER after_order_details_insert
            AFTER INSERT ON order_details
            FOR EACH ROW
            BEGIN
                UPDATE books
                SET stock = stock - NEW.quantity
                WHERE id = NEW.book_id;
            END
        ');

        // Trigger to adjust stock on update
        DB::unprepared('
            CREATE TRIGGER after_order_details_update
            AFTER UPDATE ON order_details
            FOR EACH ROW
            BEGIN
                DECLARE qty_diff INT;
                SET qty_diff = NEW.quantity - OLD.quantity;

                UPDATE books
                SET stock = stock - qty_diff
                WHERE id = NEW.book_id;
            END
        ');

        // Trigger to restore stock on delete
        DB::unprepared('
            CREATE TRIGGER after_order_details_delete
            AFTER DELETE ON order_details
            FOR EACH ROW
            BEGIN
                UPDATE books
                SET stock = stock + OLD.quantity
                WHERE id = OLD.book_id;
            END
        ');
    }

    public function down()
    {
        // Drop the triggers if they exist
        DB::unprepared('DROP TRIGGER IF EXISTS after_order_details_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS after_order_details_update');
        DB::unprepared('DROP TRIGGER IF EXISTS after_order_details_delete');
    }
}
