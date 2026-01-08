<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('UserCredit', function (Blueprint $table) {
            $table->bigIncrements('ID');
            $table->string('UserName', 20);
            $table->integer('Mony');
            $table->integer('Type');
            $table->dateTime('Date');
            $table->text('Note');
            $table->string('InvoiceNo', 12)->nullable();
            $table->string('PaymentId', 255)->nullable();
            $table->string('SpecialPaymentId', 255)->nullable();
            $table->string('GateWay', 3)->nullable();
            $table->bigInteger('ReferenceId')->nullable();
            $table->string('TransferBy', 20);
            $table->string('ConfirmBy', 20)->nullable();
            $table->dateTime('Confirmdate')->nullable();
            $table->integer('RealMony')->nullable();
            $table->integer('CreditMod');
            $table->bigInteger('ZeroRefrenceID')->nullable();
            $table->bigInteger('TransfreRefrenceID')->nullable();
            $table->bigInteger('Prebill')->nullable();
            $table->bigInteger('bill')->nullable();
            $table->integer('branch')->default(1);
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
        Schema::dropIfExists('UserCredit');
    }
}
