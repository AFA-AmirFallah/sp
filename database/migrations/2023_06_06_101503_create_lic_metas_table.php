<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lic_metas', function (Blueprint $table) {
            $table->id();
            $table->string('Name',50);
            $table->integer('SysLic')->nullable();
            $table->string('note',255)->nullable();
            $table->integer('SmartIndex')->index();
            $table->integer('UserCreditIndex')->nullable()->index();
            $table->integer('type')->index();
            $table->integer('post')->nullable();
            $table->integer('tashim')->nullable();
            $table->integer('PayType')->nullable();
            $table->integer('AccountingType')->nullable();
            $table->integer('BuyPrice')->nullable();
            $table->integer('SelPrice')->nullable();
            $table->integer('status')->index();
            $table->text('PreRequest')->nullable();
            $table->text('metadata')->nullable();
            $table->text('history');
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
        Schema::dropIfExists('lic_metas');
    }
}
