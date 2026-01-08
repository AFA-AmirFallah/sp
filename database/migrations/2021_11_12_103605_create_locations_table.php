<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('Owner', 20);
            $table->string('name', 255);
            $table->string('recivername', 255);
            $table->string('reciverphone', 20);
            $table->string('Province', 30);
            $table->integer('ProvinceID');
            $table->string('City', 30);
            $table->integer('CityID');
            $table->string('Street', 30);
            $table->text('OthersAddress')->nullable();
            $table->string('Pelak', 10)->nullable();
            $table->string('PostalCode', 10)->nullable();
            $table->text('ExtraNote')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->integer('Status')->default(1);
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
        Schema::dropIfExists('locations');
    }
}
