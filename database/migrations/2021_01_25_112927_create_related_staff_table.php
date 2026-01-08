<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelatedStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('RelatedStaff', function (Blueprint $table) {
            $table->id();
            $table->string('OwnerUserID',20)->index();
            $table->string('ResponserID',20)->index();
            $table->bigInteger('ContractID')->nullable()->index();
            $table->dateTime('CreateDate');
            $table->string('CreateBy',20)->index();
            $table->dateTime('StartRespns')->nullable()->index();
            $table->dateTime('EndRespns')->nullable()->index();
            $table->integer('RespnsType')->index();
            $table->string('DeletedBy',20)->nullable();
            $table->dateTime('DeletedTime')->nullable();
            $table->text('Note');
            $table->integer('Point')->nullable()->index();
            $table->integer('Price')->nullable();
            $table->text('EndNote');
            $table->string('Confirmer',20)->nullable()->index();
            $table->bigInteger('RelatedCredite')->nullable()->index();
            $table->integer('branch')->nullable();
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
        Schema::dropIfExists('RelatedStaff');
    }
}
