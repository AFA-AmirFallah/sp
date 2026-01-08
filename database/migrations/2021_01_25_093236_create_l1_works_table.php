<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateL1WorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('L1Work', function (Blueprint $table) {
            $table->integer('WorkCat');
            $table->integer('L1ID');
            $table->string('Name',100);
            $table->string('Description',200)->nullable();
            $table->text('img');
            $table->timestamps();
            $table->primary(['WorkCat','L1ID']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('L1Work');
    }
}
