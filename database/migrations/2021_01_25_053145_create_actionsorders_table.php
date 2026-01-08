<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionsordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actionsorder', function (Blueprint $table) {
            $table->integer('ID')->autoIncrement();
            $table->bigInteger('OrderID');
            $table->integer('status');
            $table->string('UserAction', 20);
            $table->dateTime('CreateDate');
            $table->text('Extranote');
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
        Schema::dropIfExists('actionsorder');
    }
}
