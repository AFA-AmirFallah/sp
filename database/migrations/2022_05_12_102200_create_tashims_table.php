<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTashimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tashims', function (Blueprint $table) {
            $table->id();
            $table->integer('TashimID');
            $table->integer('ItemOrder');
            $table->string('Name',255);
            $table->string('TargetUser',20);
            $table->text('FormolStr'); // 0: Money 1:Def_Money Others:ExactMony
            $table->string('Operation',255); // + - * /
            $table->integer('CreditMod');
            $table->integer('CreditIndex')->nullable();
            $table->string('Confirmby',20)->nullable();
            $table->string('NoteBefore',255)->nullable();
            $table->string('NoteAfter',255)->nullable();
            $table->text('Note')->nullable();
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
        Schema::dropIfExists('tashims');
    }
}
