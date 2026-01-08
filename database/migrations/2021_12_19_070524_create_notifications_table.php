<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('TargetUser',20)->nullable();
            $table->integer('TargetRole')->nullable();
            $table->text('UserList')->nullable();
            $table->string('AcceptKey',10)->nullable();
            $table->string('Creator',20);
            $table->text('Container');
            $table->dateTime('ViewTime')->nullable();
            $table->dateTime('AckTime')->nullable();
            $table->integer('status')->default(0);
            $table->integer('AlertType');
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
        Schema::dropIfExists('notifications');
    }
}
