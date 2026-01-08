<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserlicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userlics', function (Blueprint $table) {
            $table->id();
            $table->string('UserName',20)->index();
            $table->integer('MetaLic')->index();
            $table->integer('status')->index();
            $table->integer('CreditReference')->nullable()->index();
            $table->text('metadata')->nullable();
            $table->text('history');
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
        Schema::dropIfExists('userlics');
    }
}
