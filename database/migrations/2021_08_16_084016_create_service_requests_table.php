<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->string('Owner', 20);
            $table->string('Provider', 20);
            $table->smallInteger('Status');
            $table->integer('CatID')->default(0);
            $table->dateTime('ExpireTime')->nullable();
            $table->dateTime('AcceptTime')->nullable();
            $table->dateTime('StartTime')->nullable();
            $table->dateTime('FinishTime')->nullable();
            $table->dateTime('ConfirmTime')->nullable();
            $table->smallInteger('point')->nullable();
            $table->text('ExtraNote')->nullable();
            $table->integer('PaymentRefrence')->nullable();
            $table->string('Token', 20)->nullable();
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
        Schema::dropIfExists('service_requests');
    }
}
