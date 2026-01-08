<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketMainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TicketMain', function (Blueprint $table) {
            $table->bigInteger('TicketID')->autoIncrement();
            $table->string('UserName',20);
            $table->text('Subject');
            $table->smallInteger('Priority')->nullable();
            $table->dateTime('CreateDate')->nullable();
            $table->date('LastModifyDate')->nullable();
            $table->string('LastReplyUser',20)->nullable();
            $table->integer('State')->nullable();
            $table->text('Text');
            $table->string('FromUser',20)->nullable();
            $table->tinyInteger('AlarmShow')->default('1');
            $table->smallInteger('Point')->nullable();
            $table->integer('RelatedRole')->nullable();
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
        Schema::dropIfExists('TicketMain');
    }
}
