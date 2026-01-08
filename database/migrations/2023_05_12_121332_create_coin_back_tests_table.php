<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoinBackTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coin_back_tests', function (Blueprint $table) {
            $table->bigInteger('candate')->index();
            $table->string('curency', 30)->index();
            $table->string('owner', 20)->index();
            $table->integer('OfferType')->index();
            $table->string('OpenPrice', 30);
            $table->string('C5MuinPrice', 30)->nullable();
            $table->float('C5MuinPercent')->nullable();
            $table->string('C15MuinPrice', 30)->nullable();
            $table->float('C15MuinPercent')->nullable();
            $table->string('C30MuinPrice', 30)->nullable();
            $table->float('C30MuinPercent')->nullable();
            $table->string('C1HourPrice', 30)->nullable();
            $table->float('C1HourPercent')->nullable();
            $table->string('C2HourPrice', 30)->nullable();
            $table->float('C2HourPercent')->nullable();
            $table->string('C4HourPrice', 30)->nullable();
            $table->float('C4HourPercent')->nullable();
            $table->string('C24HourPrice', 30)->nullable();
            $table->float('C24HourPercent')->nullable();
            $table->integer('status')->default(0)->index();
            $table->text('extrainfo')->nullable();
            $table->primary(['candate', 'curency','owner']);
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
        Schema::dropIfExists('coin_back_tests');
    }
}
