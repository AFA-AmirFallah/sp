<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AllShifts extends Migration
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
   VIEW `AllShifts` AS 
        SELECT
        `RelatedStaff`.`id` AS `service_id`,
        `RelatedStaff`.`OwnerUserID` AS `OwnerUserID`,
        `RelatedStaff`.`ResponserID` AS `ResponserID`,
        `UserInfo`.`Name` AS `Name`,
        `UserInfo`.`Family` AS `Family`,
        `UserInfo`.`avatar` AS `avatar`,
        `RelatedStaff`.`ContractID` AS `ContractID`,
        `RelatedStaff`.`CreateDate` AS `CreateDate`,
        `RelatedStaff`.`CreateBy` AS `CreateBy`,
        `RelatedStaff`.`StartRespns` AS `StartRespns`,
        `RelatedStaff`.`EndRespns` AS `EndRespns`,
        `RelatedStaff`.`RespnsType` AS `RespnsType`,
        `RespnsType`.`RespnsTypeName` AS `RespnsTypeName`,
        `RelatedStaff`.`DeletedBy` AS `DeletedBy`,
        `RelatedStaff`.`DeletedTime` AS `DeletedTime`,
        `RelatedStaff`.`Note` AS `Note`,
        `RelatedStaff`.`EndNote` AS `EndNote`,
        `RelatedStaff`.`Point` AS `Point`,
        `RelatedStaff`.`RelatedCredite` AS `RelatedCredite`
        FROM
        (
            (
                `RelatedStaff`
            JOIN `UserInfo` ON `UserInfo`.`UserName` = `RelatedStaff`.`ResponserID`
            )
        JOIN `RespnsType` ON `RespnsType`.`ID` = `RelatedStaff`.`RespnsType`
        )
        WHERE
        (
            ISNULL(`RelatedStaff`.`Confirmer`) AND(`RelatedStaff`.`EndRespns` < NOW()) AND ISNULL(`RelatedStaff`.`DeletedBy`))
        ORDER BY
            `RelatedStaff`.`StartRespns`
        DESC;");
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
