<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coins', function (Blueprint $table) {
            $table->id();
            $table->string('UserName', 20);
            $table->string('CoinName', 20);
            $table->float('QTY');
            $table->float('TMNUpLimit')->nullable();
            $table->float('TMN');
            $table->float('TMNDownLimit')->nullable();
            $table->integer('Robot')->nullable();
            $table->integer('Status')->default(0);
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
        Schema::dropIfExists('coins');
    }
}
