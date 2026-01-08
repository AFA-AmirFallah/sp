<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddorder1sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addorder1', function (Blueprint $table) {
            $table->bigInteger('ID')->autoIncrement()->unique('ID');
            $table->string('UserName', 20);
            $table->string('BimarUserName', 20);
            $table->integer('CatID');
            $table->dateTime('CreateDate');
            $table->integer('Status');
            $table->text('Address');
            $table->text('Extranote');
            $table->bigInteger('state')->nullable();
            $table->integer('branch');
            $table->dateTime('suggest_time')->nullable();
            $table->text('AttachFiles')->nullable();
            $table->bigInteger('PearID')->nullable();
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
        Schema::dropIfExists('addorder1');

    }
}
