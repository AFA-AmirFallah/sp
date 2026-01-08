<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTashimToProductOrderItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_order_items', function (Blueprint $table) {
            $table->integer('Tashim')->after('product_qty')->nullable();
            $table->integer('main_unit_price')->after('unit_Price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_order_items', function (Blueprint $table) {
            //
        });
    }
}
