<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCrediteTotallViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE
 ALGORITHM = UNDEFINED
 VIEW `user_credite_totall`
 AS SELECT UserCredit.UserName, sum(UserCredit.Mony) as Mony, UserCreditModMeta.ModName, UserCredit.CreditMod from UserCredit INNER JOIN UserCreditModMeta on UserCredit.CreditMod = UserCreditModMeta.ID WHERE UserCredit.ConfirmBy is NOT null GROUP BY UserCredit.UserName , UserCreditModMeta.ModName ,UserCredit.CreditMod
");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW user_credite_totall");

    }
}
