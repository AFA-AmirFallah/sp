<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('Name',100);
            $table->text('Address');
            $table->string('Phone',11);
            $table->string('Mobile',11);
            $table->string('Owner',20);
            $table->tinyInteger('Status');
            $table->tinyInteger('Type');
            $table->tinyInteger('Field');
            $table->string('ContractID',20)->nullable();
            $table->dateTime('CreateDate')->nullable();
            $table->date('expiredDate')->nullable();
            $table->string('License',20);
            $table->integer('branch');
            $table->text('Pic')->nullable();
            $table->string('Malek',255)->nullable();
            $table->text('Description')->nullable();
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
        Schema::dropIfExists('stores');
    }
}
