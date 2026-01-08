<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_views', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('MobileNumber', 255)->nullable();
            $table->string('UserName', 255)->nullable();
            $table->text('message');
            $table->integer('Post');
            $table->smallInteger('Status')->default(1);
            $table->integer('refrence')->nullable();
            $table->string('Publisher',20)->nullable();
            $table->text('ExtraInfo')->nullable();
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
        Schema::dropIfExists('post_views');
    }
}
