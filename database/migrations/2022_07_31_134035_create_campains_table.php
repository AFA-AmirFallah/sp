<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campains', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('Campain_meta');
            $table->string('CodeId',30)->nullable();
            $table->smallInteger('staus')->default(0);
            $table->integer('qty');
            $table->integer('remain');
            $table->bigInteger('product_uid')->nullable();
            $table->bigInteger('User_uid')->nullable();
            $table->integer('min_price')->nullable();
            $table->integer('max_price')->nullable();
            $table->string('creator',20);
            $table->string('confirmby',20)->nullable();
            $table->string('Userid',20)->nullable();
            $table->bigInteger('productid')->nullable();
            $table->bigInteger('pwid')->nullable();
            $table->bigInteger('branch')->nullable();
            $table->text('condition')->nullable();
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
        Schema::dropIfExists('campains');
    }
}
