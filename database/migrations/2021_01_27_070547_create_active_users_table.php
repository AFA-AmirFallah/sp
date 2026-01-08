<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActiveUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ActiveUsers', function (Blueprint $table) {
            $table->string('ActivePerson', 20);
            $table->dateTime('StartTime');
            $table->dateTime('EndTime');
            $table->timestamps();
            $table->primary(['ActivePerson', 'StartTime']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ActiveUsers');
    }
}
