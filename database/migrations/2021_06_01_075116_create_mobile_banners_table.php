<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobileBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_banner', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('page');
            $table->integer('UserRole')->nullable();
            $table->integer('order');
            $table->integer('theme');
            $table->string('MainTheme',5)->nullable();
            $table->text('title');
            $table->text('pic');
            $table->text('link');
            $table->integer('linkMeta')->nullable();
            $table->integer('status');
            $table->text('targetaddress')->nullable();
            $table->text('content')->nullable();
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
        Schema::dropIfExists('mobile_banners');
    }
}
