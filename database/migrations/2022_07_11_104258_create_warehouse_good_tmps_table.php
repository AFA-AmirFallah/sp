<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseGoodTmpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_good_tmps', function (Blueprint $table) {
            $table->id();
            $table->integer('WarehouseID');
            $table->integer('GoodID');
            $table->integer('QTY');
            $table->integer('BuyPrice');
            $table->text('BuyNote')->nullable();
            $table->integer('BasePrice')->default(0);
            $table->integer('MaxPrice');
            $table->integer('Price');
            $table->integer('MinPrice');
            $table->text('PricePlan')->nullable();
            $table->smallInteger('OnSale')->nullable();
            $table->smallInteger('SaleLimit')->default(10);
            $table->smallInteger('Discount')->default(0);
            $table->smallInteger('AlertLimit')->nullable();
            $table->tinyInteger('AlertFinish')->nullable();
            $table->date('InputDate');
            $table->dateTime('ActiveTime');
            $table->dateTime('DeactiveTime');
            $table->date('MadeDate');
            $table->date('ExpireDate')->nullable();
            $table->integer('Remian');
            $table->text('extra')->nullable();
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
        Schema::dropIfExists('warehouse_good_tmps');
    }
}
