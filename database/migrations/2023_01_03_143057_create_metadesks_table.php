<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetadesksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metadesks', function (Blueprint $table) {
            $table->id();
            $table->integer('desk')->default(0);
            $table->string('UserName',20)->nullable();
            $table->string('tt',30);
            $table->bigInteger('fgint')->nullable();
            $table->string('fgstr',20)->nullable();
            $table->string('meta_key',50);
            $table->text('meta_value');
            $table->text('history');
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('metadesks');
    }
}
