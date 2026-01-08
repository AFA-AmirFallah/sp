<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('MainName', 30)->index();
            $table->string('FaName', 30)->nullable()->index();
            $table->string('symbol', 30)->index();
            $table->string('name', 30)->index();
            $table->string('baseCurrency', 30);
            $table->string('quoteCurrency', 30);
            $table->string('feeCurrency', 30);
            $table->string('market', 30)->index();
            $table->string('baseMinSize', 30);
            $table->string('quoteMinSize', 30);
            $table->string('baseMaxSize', 30);
            $table->string('quoteMaxSize', 30);
            $table->string('baseIncrement', 30);
            $table->string('quoteIncrement', 30);
            $table->string('priceIncrement', 30);
            $table->string('priceLimitRate', 30);
            $table->string('minFunds', 30);
            $table->boolean('isMarginEnabled');
            $table->boolean('enableTrading');
            $table->integer('status')->default(0)->index();
            $table->string('buy', 30)->nullable();
            $table->string('sell', 30)->nullable();
            $table->string('changeRate', 10)->nullable()->index();
            $table->float('changeRateInt')->nullable()->index();
            $table->string('changePrice', 30)->nullable();
            $table->string('high', 30)->nullable();
            $table->string('low', 30)->nullable();
            $table->string('vol', 30)->nullable();
            $table->string('volValue', 30)->nullable();
            $table->string('last', 30)->nullable();
            $table->string('averagePrice', 30)->nullable();
            $table->string('takerFeeRate', 30)->nullable();
            $table->string('makerFeeRate', 30)->nullable();
            $table->string('takerCoefficient', 30)->nullable();
            $table->string('makerCoefficient', 30)->nullable();
            $table->text('pic')->nullable();
            $table->text('ExtraInfo')->nullable();
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
        Schema::dropIfExists('currencies');
    }
}
