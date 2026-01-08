<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Work', function (Blueprint $table) {
            $table->bigInteger('WorkID')->primary();
            $table->integer('EmpID')->unsigned();
            $table->integer('CatID');
            $table->integer('L1ID');
            $table->integer('L2ID');
            $table->integer('L3ID');
            $table->text('Description');
            $table->integer('MaxPrice');
            $table->date('DeadLine');
            $table->date('responseTime');
            $table->integer('State');
            $table->integer('TCode');
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
        Schema::dropIfExists('Work');
    }
}
