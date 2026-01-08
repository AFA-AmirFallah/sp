<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AllShiftsTotall extends Migration
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
   VIEW `AllShiftsTotall` AS 
        SELECT
            `AllShifts`.`service_id` AS `service_id`,
            `AllShifts`.`OwnerUserID` AS `OwnerUserID`,
            `UserInfo`.`Name` AS `OwnerName`,
            `UserInfo`.`Family` AS `OwnerFamily`,
            `AllShifts`.`avatar` AS `Owneravatar`,
            `AllShifts`.`ResponserID` AS `ResponserID`,
            `AllShifts`.`Name` AS `ResponserName`,
            `AllShifts`.`Family` AS `ResponserFamily`,
            `AllShifts`.`avatar` AS `ResponserAvatar`,
            `AllShifts`.`ContractID` AS `ContractID`,
            `AllShifts`.`CreateDate` AS `CreateDate`,
            `AllShifts`.`CreateBy` AS `CreateBy`,
            `AllShifts`.`StartRespns` AS `StartRespns`,
            `AllShifts`.`EndRespns` AS `EndRespns`,
            `AllShifts`.`RespnsType` AS `RespnsType`,
            `AllShifts`.`RespnsTypeName` AS `RespnsTypeName`,
            `AllShifts`.`DeletedBy` AS `DeletedBy`,
            `AllShifts`.`DeletedTime` AS `DeletedTime`,
            `AllShifts`.`Note` AS `Note`,
            `AllShifts`.`EndNote` AS `EndNote`,
            `AllShifts`.`RelatedCredite` AS `RelatedCredite`
        FROM
            (
                `AllShifts`
            JOIN `UserInfo` ON `AllShifts`.`OwnerUserID` = `UserInfo`.`UserName`
            )
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
