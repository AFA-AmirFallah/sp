<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->id();
            $table->string('SKU',20)->nullable();
            $table->string('NameFa',300);
            $table->string('NameEn',50);
            $table->string('IRID',50)->nullable();
            $table->string('IntID',60)->nullable();
            $table->tinyInteger('Virtual')->default(0);
            $table->tinyInteger('downloadable')->default(0);
            $table->tinyInteger('onsale')->default(0);
            $table->integer('Status');
            $table->string('Description',100);
            $table->integer('MinPrice')->nullable();
            $table->integer('MaxPrice')->nullable();
            $table->integer('Unit');
            $table->text('MainDescription');
            $table->text('ImgURL');
            $table->integer('stock_quantity')->default(0);
            $table->integer('stock_status')->default(0);
            $table->integer('rating_count')->default(0);
            $table->integer('average_rating')->default(0);
            $table->integer('total_sales')->default(0);
            $table->integer('tax_status')->default(0);
            $table->integer('weight')->default(0);
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
        Schema::dropIfExists('goods');
    }
}
