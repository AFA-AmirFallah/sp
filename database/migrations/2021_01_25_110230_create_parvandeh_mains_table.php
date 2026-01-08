<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParvandehMainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ParvandehMain', function (Blueprint $table) {
            $table->bigInteger('ParvandehID')->autoIncrement()->unsigned();
            $table->string('UserName',20);
            $table->text('Subject');
            $table->smallInteger('Priority')->nullable();
            $table->date('CreateDate');
            $table->date('LastModifyDate')->nullable();
            $table->string('LastReplyUser',20)->nullable();
            $table->integer('State')->nullable();
            $table->text('Text');
            $table->string('FromUser',20);
            $table->tinyInteger('AlarmShow')->default('1');
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
        Schema::dropIfExists('ParvandehMain');
    }
}
