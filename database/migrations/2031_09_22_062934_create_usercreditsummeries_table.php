<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsercreditsummeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE
   ALGORITHM = UNDEFINED
   VIEW `usercreditsummery`
   AS select `UserCredit`.`UserName` AS `UserName`,sum(`UserCredit`.`Mony`) AS `SUMMony`,`UserCredit`.`CreditMod` AS `CreditMod`from `UserCredit` where `UserCredit`.`ConfirmBy` is not null group by `UserCredit`.`UserName`,`UserCredit`.`CreditMod`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usercreditsummeries');
    }
}
