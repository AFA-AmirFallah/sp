<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catorder', function (Blueprint $table) {
            $table->id();
            $table->string('center_id', 25)->index();
            $table->string('Cat', 255);
            $table->smallInteger('CatType')->index();
            $table->string('TitleDescription', 500)->nullable();
            $table->text('MainDescription')->nullable();
            $table->text('Pic')->nullable();
            $table->text('Pics')->nullable();
            $table->bigInteger('used')->default(0);
            $table->integer('MainIndex')->nullable()->index();
            $table->bigInteger('customer_index')->nullable()->index();
            $table->bigInteger('worker_index')->nullable()->index();
            $table->smallInteger('Status')->default('1');
            $table->boolean('OnSale')->default(false);
            $table->smallInteger('branch')->default('1');
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
        Schema::dropIfExists('catorder');
    }
}
