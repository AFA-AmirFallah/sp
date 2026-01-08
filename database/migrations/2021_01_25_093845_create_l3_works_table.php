<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateL3WorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('L3Work', function (Blueprint $table) {
            $table->integer('UID')->autoIncrement();
            $table->integer('WorkCat');
            $table->integer('L1ID');
            $table->integer('L2ID');
            $table->integer('L3ID');
            $table->string('Name',100);
            $table->string('Description',200)->nullable();
            $table->text('img')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('L3Work');
    }
}
