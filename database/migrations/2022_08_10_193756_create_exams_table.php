<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('SKU',20)->nullable();
            $table->string('NameFa',300);
            $table->string('NameEn',50);
            $table->string('unit',50);
            $table->tinyInteger('onsale')->default(0);
            $table->integer('Status');
            $table->text('Description');
            $table->text('ImgURL')->nullable();
            $table->integer('rating_count')->default(0);
            $table->integer('average_rating')->default(0);
            $table->integer('total_sales')->default(0);
            $table->text('BuyNote')->nullable();
            $table->integer('BasePrice')->default(0);
            $table->integer('Price');
            $table->text('variables');
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
        Schema::dropIfExists('exams');
    }
}
