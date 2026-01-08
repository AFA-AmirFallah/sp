<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('UserInfo', function (Blueprint $table) {
            $table->string('UserName',20)->primary();
            $table->string('UserPass',255)->nullable();
            $table->string('password',255);
            $table->string('Name',50);
            $table->string('Family',80);
            $table->string('MobileNo',11);
            $table->text('NationalCode')->nullable();
            $table->text('ShSh')->nullable();
            $table->string('Email',255);
            $table->string('Phone1',20)->nullable();
            $table->string('Phone2',20)->nullable();
            $table->integer('Ext')->nullable();
            $table->text('Address')->nullable();
            $table->date('Birthday')->nullable();
            $table->dateTime('CreateDate')->nullable();;
            $table->tinyInteger('Role');
            $table->tinyInteger('Status');
            $table->string('MarketingCode',20)->nullable();
            $table->string('Sex',1)->nullable();
            $table->string('MelliID',10)->nullable();
            $table->string('fathername',30)->nullable();
            $table->tinyInteger('Marid')->nullable();
            $table->integer('Degree')->nullable();
            $table->integer('sarbazi')->nullable();
            $table->text('Address2')->nullable();
            $table->text('extranote')->nullable();
            $table->text('avatar')->nullable();
            $table->integer('branch')->nullable();
            $table->integer('CreditePlan')->nullable();
            $table->string('remember_token',100)->nullable();
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
        Schema::dropIfExists('UserInfo');
    }
}
