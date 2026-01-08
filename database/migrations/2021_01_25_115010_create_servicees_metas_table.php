<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceesMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ServiceesMeta', function (Blueprint $table) {
            $table->integer('ServiceesID')->autoIncrement();
            $table->string('Name', 100);
            $table->text('Note');
            $table->integer('PageID');
            $table->integer('UID');
            $table->integer('MarketingPercent');
            $table->integer('DgKarPercent');
            $table->integer('Type');
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
        Schema::dropIfExists('ServiceesMeta');
    }
}
