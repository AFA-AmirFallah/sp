<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceItemInternalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DeviceItemInternal', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ContractNumber')->unsigned();
            $table->integer('SubItem');
            $table->integer('Device');
            $table->integer('Price');
            $table->integer('product_id')->nullable();
            $table->integer('product_qty')->nullable();
            $table->string('customer_id',20)->nullable();
            $table->string('Owner',20)->nullable();
            $table->integer('Ownerbranch')->nullable();
            $table->integer('unit_Price')->default(0);
            $table->integer('unit_sales')->default(0);
            $table->integer('total_sales')->default(0);
            $table->integer('tax_total')->default(0);
            $table->integer('customer_benefit_total')->default(0);
            $table->integer('shipping_amount')->default(0);
            $table->integer('OwnerPrice')->default(0);
            $table->integer('net_total')->default(0);
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
        Schema::dropIfExists('DeviceItemInternal');
    }
}
