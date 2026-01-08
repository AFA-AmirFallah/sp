<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespnsTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('RespnsType', function (Blueprint $table) {
            $table->id();
            $table->string('center_id', 25)->index();
            $table->string('RespnsTypeName', 100);
            $table->smallInteger('ServiceType')->index();
            $table->smallInteger('price_type')->index();
            $table->integer('hPrice')->default('0');
            $table->integer('fixPrice')->default('0');
            $table->integer('CustomerhPrice')->default('0');
            $table->integer('CustomerfixPrice')->default('0');
            $table->integer('UserCreditIndex')->nullable();
            $table->integer('tashim')->nullable();
            $table->bigInteger('used')->default(0);
            $table->integer('MainIndex')->nullable()->index();
            $table->bigInteger('customer_index')->nullable()->index();
            $table->bigInteger('worker_index')->nullable()->index();
            $table->integer('Status');
            $table->boolean('OnSale')->default(false);
            $table->text('Description')->nullable();
            $table->text('MainDescription')->nullable();
            $table->text('ImgURL')->nullable();
            $table->integer('branch')->index();
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
        Schema::dropIfExists('RespnsType');
    }
}
