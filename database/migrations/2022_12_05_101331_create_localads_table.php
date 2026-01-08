<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocaladsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('localads', function (Blueprint $table) {
            $table->id();
            $table->string('TargetPage',20);
            $table->integer('adsid');
            $table->integer('views');
            $table->string('viewer',20)->nullable(); //username
            $table->string('action',20);
            $table->string('ipaddress',50)->nullable(); //nulable for ipv6s
            $table->string('session',50);
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
        Schema::dropIfExists('localads');
    }
}
