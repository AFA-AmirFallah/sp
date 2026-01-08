<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadReqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload_reqs', function (Blueprint $table) {
            $table->id();
            $table->string('TargetUser', 20);
            $table->string('ReqUser', 20);
            $table->string('RequstText',255);
            $table->string('Token',255);
            $table->integer('Status');
            $table->text('FileAddress')->nullable();
            $table->dateTime('Expire')->nullable();
            $table->boolean('Alert')->default(false);
            $table->boolean('ForceToLogin')->default(false);
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
        Schema::dropIfExists('upload_reqs');
    }
}
