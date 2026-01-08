<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkRegisterdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('WorkRegisterd', function (Blueprint $table) {
            $table->integer('WorkNo')->unsigned()->primary();
            $table->string('OwnerUser',20);
            $table->date('CreateDate');
            $table->integer('State');
            $table->integer('Price')->unsigned();
            $table->integer('PayAmount')->unsigned();
            $table->integer('MetaServiceID');
            $table->text('Address');
            $table->date('StartDate');
            $table->dateTime('ApplyDeadLine');
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
        Schema::dropIfExists('WorkRegisterd');
    }
}
