<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCreditReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('UserCreditReport', function (Blueprint $table) {
            $table->date('Confirmdate')->nullable();
            $table->integer('ID');
            $table->integer('input')->nullable();
            $table->integer('output')->nullable();
            $table->integer('daramad')->nullable();
            $table->integer('creditmode');
            $table->integer('UserCreditIndex');
            $table->integer('Type')->nullable();
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
        Schema::dropIfExists('UserCreditReport');
    }
}
