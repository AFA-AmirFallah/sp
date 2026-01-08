<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceItemExternalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DeviceItemExternal', function (Blueprint $table) {
            $table->bigInteger('ContractNumber')->unsigned();
            $table->integer('SubItem')->unsigned();
            $table->integer('Owner');
            $table->integer('DeviceMeta');
            $table->integer('DeviceModel');
            $table->text('AmvalNumber');
            $table->text('SerialNumber');
            $table->integer('Price');
            $table->integer('OwnerPrice')->default(0);
            $table->text('Note');
            $table->timestamps();
            $table->primary(['ContractNumber','SubItem']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('DeviceItemExternal');
    }
}
