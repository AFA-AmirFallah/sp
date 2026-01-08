<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Devices', function (Blueprint $table) {
            $table->integer('ID')->autoIncrement()->unsigned();
            $table->integer('Owner');
            $table->integer('DeviceMeta');
            $table->integer('DeviceModel');
            $table->string('AmvalNumber',100);
            $table->integer('SerialNumber');
            $table->integer('Status');
            $table->text('Notes');
            $table->timestamps();
            $table->unique(['Owner','AmvalNumber']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Devices');
    }
}
