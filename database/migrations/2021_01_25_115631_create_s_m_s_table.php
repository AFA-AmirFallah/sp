<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSMSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SMS', function (Blueprint $table) {
            $table->bigInteger('SMSID')->autoIncrement()->unsigned();
            $table->string('Sender', 20);
            $table->string('SenderPhone', 14);
            $table->string('Reciver', 20);
            $table->string('ReciverPhone', 14);
            $table->integer('isSend');
            $table->dateTime('SMSTime');
            $table->integer('Status');
            $table->text('Message');
            $table->text('Result');
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
        Schema::dropIfExists('SMS');
    }
}
