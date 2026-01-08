<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlertmesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alertmes', function (Blueprint $table) {
            $table->id();
            $table->string('UserName',20);
            $table->integer('RequestProduct');
            $table->text('note')->nullable();
            $table->integer('status')->default(0);
            $table->text('ExtraNotes')->nullable();
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
        Schema::dropIfExists('alertmes');
    }
}
