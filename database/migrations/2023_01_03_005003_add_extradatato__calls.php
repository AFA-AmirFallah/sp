<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtradatatoCalls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Calls', function (Blueprint $table) {
            $table->text('recloc')->after('ChannelID')->nullable();
            $table->text('ExtraInfo')->after('ChannelID')->nullable();
            $table->integer('Status')->after('AnswerUser')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Calls', function (Blueprint $table) {
            //
        });
    }
}
