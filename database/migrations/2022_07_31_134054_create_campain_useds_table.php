<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampainUsedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campain_useds', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('Campain');
            $table->bigInteger('Campain_meta');
            $table->string('username',20);
            $table->integer('price');
            $table->integer('remian_price');
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
        Schema::dropIfExists('campain_useds');
    }
}
