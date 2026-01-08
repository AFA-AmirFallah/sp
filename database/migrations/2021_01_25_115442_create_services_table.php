<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Services', function (Blueprint $table) {
            $table->integer('UserID');
            $table->integer('ServiceMeta');
            $table->integer('ServiceItem');
            $table->integer('Price');
            $table->smallInteger('State');
            $table->timestamps();
            $table->primary(['UserID','ServiceMeta','ServiceItem']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Services');
    }
}
