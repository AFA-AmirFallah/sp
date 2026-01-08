<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateL2WorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('L2Work', function (Blueprint $table) {
            $table->integer('WorkCat');
            $table->integer('L1ID');
            $table->integer('L2ID');
            $table->string('Name',100);
            $table->string('Description',200)->nullable();
            $table->text('img');
            $table->timestamps();
            $table->primary(['WorkCat','L1ID','L2ID']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('L2Work');
    }
}
