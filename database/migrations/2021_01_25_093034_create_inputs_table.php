<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Inputs', function (Blueprint $table) {
            $table->bigInteger('TraceCode')->autoIncrement()->unsigned();
            $table->integer('cooperator');
            $table->dateTime('recivetime');
            $table->text('input');
            $table->integer('Status')->default('0');
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
        Schema::dropIfExists('Inputs');
    }
}
