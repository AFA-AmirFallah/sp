<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserInfoWithPrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE ALGORITHM=UNDEFINED   VIEW `UserInfoWithPrice` AS
        select `UserInfo`.`UserName` AS `UserNameMain`,`UserInfo`.`Name` AS `Name`,`UserInfo`.`Family` AS `Family`,`UserInfo`.`province`,`UserInfo`.`city`,
        `UserInfo`.`extranote` AS `extranote`,`UserInfo`.`MobileNo` AS `MobileNo`,`UserInfo`.`Email` AS `Email`,`UserInfo`.`Status` AS `Status`,`UserInfo`.`avatar` AS `avatar`,(select ifnull(sum(`UserCredit`.`Mony`),0) AS `mony` from `UserCredit` where ((`UserCredit`.`UserName` = `UserInfo`.`UserName`) and (`UserCredit`.`CreditMod` = 1) and (`UserCredit`.`Confirmdate` is not null))) AS `mony`,0 AS `blocked`,`UserInfo`.`Sex` AS `Sex`,`UserInfo`.`Role` AS `Role`,`UserInfo`.`branch` AS `branch`,`UserInfo`.`CreateDate` AS `CreateDate` from `UserInfo`
");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}


