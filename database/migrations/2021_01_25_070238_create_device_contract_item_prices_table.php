<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceContractItemPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DeviceContractItemPrice', function (Blueprint $table) {
            $table->integer('ContractType');
            $table->integer('DeviceID');
            $table->integer('Price');
            $table->integer('fixPrice')->nullable();
            $table->primary(['ContractType', 'DeviceID']);
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
        Schema::dropIfExists('DeviceContractItemPrice');
    }
}
