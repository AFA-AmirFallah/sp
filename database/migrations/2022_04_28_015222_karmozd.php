<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Karmozd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Karmozd', function (Blueprint $table) {
            $table->id();
            $table->string('Name',20);
            $table->smallInteger('KarmozdOperationType');
            $table->integer('KarmozdOperation');
            $table->smallInteger('KarmozdGhestType');
            $table->integer('KarmozdGhest');
            $table->integer('Duration'); //days
            $table->integer('status');
            $table->integer('Periority');
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
        //
    }
}
