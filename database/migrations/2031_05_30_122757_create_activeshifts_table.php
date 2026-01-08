<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActiveshiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE ALGORITHM=UNDEFINED  VIEW `activeShift` AS select `RelatedStaff`.`OwnerUserID` AS `OwnerUserID`,`RelatedStaff`.`ResponserID` AS `ResponserID`,`UserInfo`.`Name` AS `Name`,`UserInfo`.`Family` AS `Family`,`RelatedStaff`.`ContractID` AS `ContractID`,`RelatedStaff`.`CreateDate` AS `CreateDate`,`RelatedStaff`.`CreateBy` AS `CreateBy`,`RelatedStaff`.`StartRespns` AS `StartRespns`,`RelatedStaff`.`EndRespns` AS `EndRespns`,`RelatedStaff`.`RespnsType` AS `RespnsType`,`RespnsType`.`RespnsTypeName` AS `RespnsTypeName`,`RelatedStaff`.`DeletedBy` AS `DeletedBy`,`RelatedStaff`.`DeletedTime` AS `DeletedTime`,`RelatedStaff`.`Note` AS `Note`,`UserInfo`.`MobileNo` AS `ownerMobile`,`RelatedStaff`.`branch` AS `Branch` from ((`RelatedStaff` join `UserInfo`) join `RespnsType`) where ((`UserInfo`.`UserName` = `RelatedStaff`.`ResponserID`) and (`RelatedStaff`.`StartRespns` <= now()) and (`RelatedStaff`.`EndRespns` >= now()) and (`RespnsType`.`ID` = `RelatedStaff`.`RespnsType`) and isnull(`RelatedStaff`.`DeletedBy`)) order by `RelatedStaff`.`StartRespns` desc;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activeshifts');
    }
}
