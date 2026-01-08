<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Calls', function (Blueprint $table) {
            $table->string('CallID', 20);
            $table->string('CallerNumber', 20);
            $table->string('AnsweredNumber', 20);
            $table->string('CallerUser', 20);
            $table->string('AnswerUser', 20);
            $table->dateTime('StartTime');
            $table->dateTime('EndTime');
            $table->integer('CallType');
            $table->integer('CallPoint');
            $table->integer('CallDuration');
            $table->string('ChannelID', 20);
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
        Schema::dropIfExists('Calls');
    }
}
