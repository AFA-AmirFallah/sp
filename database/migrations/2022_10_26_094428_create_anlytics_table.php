<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnlyticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anlytics', function (Blueprint $table) {
            $table->id();
            $table->integer('metakey');
            $table->string('axis_x',255)->nullable();
            $table->string('axis_y',255)->nullable();
            $table->string('axis_z',255)->nullable();
            $table->text('extradata')->nullable();
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
        Schema::dropIfExists('anlytics');
    }
}
