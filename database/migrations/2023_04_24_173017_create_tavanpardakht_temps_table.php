<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTavanpardakhtTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tavanpardakht_temps', function (Blueprint $table) {
            $table->id();
            $table->string('Name',50);
            $table->string('Family',80);
            $table->string('MobileNo',11);
            $table->string('MelliID',10);
            $table->integer('Tavan');
            $table->tinyInteger('Status')->default(0);
            $table->tinyInteger('Type')->nullable();
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
        Schema::dropIfExists('tavanpardakht_temps');
    }
}
