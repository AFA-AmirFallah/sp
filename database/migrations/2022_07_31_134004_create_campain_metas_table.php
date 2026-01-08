<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampainMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campain_metas', function (Blueprint $table) {
            $table->id();
            $table->string('name',30);
            $table->text('desc')->nullable();
            $table->smallInteger('staus')->default(0);
            $table->integer('buget');
            $table->integer('usedprice')->default(0);
            $table->dateTime('expriredate')->nullable();
            $table->dateTime('startdate')->nullable();
            $table->string('creator',20);
            $table->string('confirmby',20);
            $table->text('extra')->nullable();
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
        Schema::dropIfExists('campain_metas');
    }
}
