<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_order_items', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->integer('product_id');
            $table->integer('product_qty');
            $table->string('customer_id',20);
            $table->integer('unit_Price')->default(0);
            $table->integer('unit_sales')->default(0);
            $table->integer('total_sales')->default(0);
            $table->integer('tax_total')->default(0);
            $table->integer('customer_benefit_total')->default(0);
            $table->integer('shipping_amount')->default(0);
            $table->integer('net_total')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_order_items');
    }
}
