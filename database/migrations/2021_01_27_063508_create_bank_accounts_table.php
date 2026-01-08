<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('BankAccount', function (Blueprint $table) {
            $table->string('UserName', 20);
            $table->string('CardNo', 20);
            $table->string('Account', 30);
            $table->string('‌BankName', 20);
            $table->tinyInteger('Status');
            $table->primary(['UserName', 'CardNo']);
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
        Schema::dropIfExists('BankAccount');
    }
}
