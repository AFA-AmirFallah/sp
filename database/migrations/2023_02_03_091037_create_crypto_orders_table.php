<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptoOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_orders', function (Blueprint $table) {
            $table->id();
            $table->string('UserName', 20);
            $table->string('CreateUser', 20);
            $table->integer('formola');
            $table->string('symbol', 20);
            $table->string('type', 5);
            $table->string('side', 5);
            $table->float('price')->nullable();
            $table->float('origQty')->nullable();
            $table->float('origSum')->nullable();
            $table->float('executedPrice')->nullable();
            $table->float('executedQty')->nullable();
            $table->float('executedSum')->nullable();
            $table->integer('executedPercent')->default(0);
            $table->string('status', 20);
            $table->string('active', 5);
            $table->string('clientOrderId', 255)->nullable();
            $table->bigInteger('RefrenceID')->nullable();
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
        Schema::dropIfExists('crypto_orders');
    }
}
