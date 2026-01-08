<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('UserPoint', function (Blueprint $table) {
            $table->id();
            $table->string('UserName',20);
            $table->tinyInteger('Point');
            $table->date('CreateDate');
            $table->integer('Work');
        
            $table->string('CreatedUser', 20);
            $table->string('ConfirmUser', 20);
            $table->date('ConfirmDate');
            $table->text('Note');
            $table->integer('status');
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
        Schema::dropIfExists('UserPoint');
    }
}
