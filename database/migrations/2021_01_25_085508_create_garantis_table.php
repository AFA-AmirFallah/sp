<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGarantisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('garanti', function (Blueprint $table) {
            $table->integer('GarantiID')->autoIncrement()->unsigned();
            $table->string('UserName', 20);
            $table->date('IssueDate');
            $table->date('ExpireDate');
            $table->integer('Price')->unsigned();
            $table->integer('RelatedWork')->unsigned();
            $table->date('DeletedDate');
            $table->integer('Status');
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
        Schema::dropIfExists('garanti');
    }
}
