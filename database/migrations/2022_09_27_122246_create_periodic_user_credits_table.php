<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodicUserCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodic_user_credits', function (Blueprint $table) {
            $table->bigIncrements('ID');
            $table->string('UserName', 20);
            $table->integer('Mony');
            $table->integer('Type');
            $table->date('StartDate');
            $table->dateTime('Date')->nullable();
            $table->date('EndDate');
            $table->text('Note');
            $table->string('InvoiceNo', 12)->nullable();
            $table->string('PaymentId', 12)->nullable();
            $table->string('SpecialPaymentId', 25)->nullable();
            $table->string('GateWay', 3)->nullable();
            $table->bigInteger('ReferenceId')->nullable();
            $table->string('TransferBy', 20);
            $table->string('ConfirmBy', 20)->nullable();
            $table->dateTime('Confirmdate')->nullable();
            $table->integer('CreditMod');
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
        Schema::dropIfExists('periodic_user_credits');
    }
}
