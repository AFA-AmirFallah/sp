<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SiftwithTransfer extends Migration
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
   VIEW `SiftwithTransfer` AS 
        SELECT
            `AllShiftsTotall`.*,
            `UserCredit`.`Mony` AS `Mony`,
            `UserCredit`.`Note` AS `CreditNote`,
            `UserCredit`.`Date` AS `CrediteDate`,
            `UserCredit`.`ID` AS `UserCreditID`,
            `UserCredit`.`UserName` AS `UserName`,
            `UserCredit`.`CreditMod` AS `ShiftCreditMod`
        FROM
            (
                `AllShiftsTotall`
            JOIN `UserCredit`
            )
        WHERE
            (
                CASE WHEN(
                    `AllShiftsTotall`.`RelatedCredite` = ''
                ) THEN(
                    (
                        `AllShiftsTotall`.`ResponserID` = `UserCredit`.`UserName`
                    ) AND(`UserCredit`.`CreditMod` = 2) AND(
                        (`UserCredit`.`ZeroRefrenceID` = 0) OR ISNULL(`UserCredit`.`ZeroRefrenceID`)
                    ) AND(`UserCredit`.`ConfirmBy` <> '')
                ) ELSE(
                    (
                        `AllShiftsTotall`.`RelatedCredite` = `UserCredit`.`ReferenceId`
                    ) AND(
                        (`UserCredit`.`ZeroRefrenceID` = 0) OR ISNULL(`UserCredit`.`ZeroRefrenceID`)
                    ) AND(`UserCredit`.`ConfirmBy` <> '')
                )
            END
        );
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
