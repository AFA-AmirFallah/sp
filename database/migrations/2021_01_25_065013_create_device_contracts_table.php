<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DeviceContract', function (Blueprint $table) {
            $table->bigInteger('ContractID')->autoIncrement()->unsigned();
            $table->string('Owner', 20);
            $table->date('ContractDate');
            $table->date('RentDate');
            $table->date('ExpireDate');
            $table->integer('Guarantee');
            $table->integer('Status');
            $table->integer('TotalPrice')->default(0);
            $table->integer('BeyanehPrice')->default(0);
            $table->integer('OwnerPrice')->default(0);
            $table->bigInteger('CreditRefrence')->nullable();
            $table->text('Note');
            $table->string('DeletedBy', 20)->nullable();
            $table->dateTime('DeletedDate')->nullable();
            $table->integer('ContractType');
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
        Schema::dropIfExists('DeviceContract');
    }
}
