<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReserveWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ReserveWork', function (Blueprint $table) {
            $table->integer('WorkID');
            $table->string('UserName',20);
            $table->dateTime('ReserveDate');
            $table->integer('Status');
            $table->timestamps();
            $table->primary(['WorkID','UserName']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ReserveWork');
    }
}
