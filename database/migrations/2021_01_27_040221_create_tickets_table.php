<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Ticket', function (Blueprint $table) {
            $table->bigInteger('TicketID');
            $table->integer('SubTicketID');
            $table->string('FromUser',20);
            $table->dateTime('CreateDate');
            $table->text('Text');
            $table->string('Attachment',50);
            $table->timestamps();
            $table->primary(['TicketID','SubTicketID']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Ticket');
    }
}
