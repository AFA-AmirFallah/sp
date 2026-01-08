<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('Owner',20);
            $table->integer('ResponseID')->nullable();
            $table->integer('Status')->default(1);
            $table->string('Ceator',20);
            $table->integer('Amount')->default(0);
            $table->integer('Branch')->default(1);
            $table->integer('BranchID')->default(0);
            $table->date('Expire')->nullable();;
            $table->dateTime('paytime')->nullable();;
            $table->integer('paymetod')->nullable();;
            $table->text('Note')->nullable();;
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
        Schema::dropIfExists('invoices');
    }
}
