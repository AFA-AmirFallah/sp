<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_orders', function (Blueprint $table) {
            $table->id();
            $table->string('CustomerId',20);
            $table->string('ReturnCustomerId',20)->nullable();
            $table->integer('SendLocation')->nullable();
            $table->integer('ReturnLocation')->nullable();
            $table->integer('ParentId')->nullable();
            $table->integer('num_items_sold')->default(0);
            $table->integer('total_sales')->default(0);
            $table->integer('tax_total')->default(0);
            $table->integer('customer_benefit_total')->default(0);
            $table->integer('TotallWeight')->default(0);
            $table->integer('shipping_total')->default(0);
            $table->integer('net_total')->default(0);
            $table->integer('status')->default(0);
            $table->text('status_history');
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
        Schema::dropIfExists('product_orders');
    }
}
