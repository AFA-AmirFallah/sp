<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntrancePersonelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrance_personels', function (Blueprint $table) {
            $table->id();
            $table->string('UserName',20);
            $table->date('WorkingDate');
            $table->time('entertime');
            $table->time('exittime')->nullable();
            $table->string('enterip',100);
            $table->string('exitip',100)->nullable();
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
        Schema::dropIfExists('entrance_personels');
    }
}
