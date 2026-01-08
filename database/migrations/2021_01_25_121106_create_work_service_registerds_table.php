<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkServiceRegisterdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('WorkServiceRegisterd', function (Blueprint $table) {
            $table->integer('WorkID')->unsigned()->primary();
            $table->smallInteger('No')->unsigned();
            $table->integer('ServiceID');
            $table->integer('Price');
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
        Schema::dropIfExists('WorkServiceRegisterd');
    }
}
