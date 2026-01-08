<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTafziliReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE ALGORITHM=UNDEFINED  VIEW tafzili_reports AS
        select cast(UserCredit.Confirmdate as date) AS ReportConfirmdate ,RespnsType.RespnsTypeName AS RespnsTypeName,
	sum(
		(
			case when (
				(UserCredit.Mony < 0)
				and (UserCredit.UserName <> 'daramad')
			) then (
				UserCredit.Mony * -(1)
			) else 0 end
		)
	) AS input,
	sum(
		(
			case when (
				(UserCredit.Mony > 0)
				and (UserCredit.UserName <> 'daramad')
			) then UserCredit.Mony else 0 end
		)
	) AS output,
	sum(
		(
			case when (UserCredit.UserName = 'daramad') then UserCredit.Mony else 0 end
		)
	) AS daramad,
	RelatedStaff.RelatedCredite AS RelatedCredite,
	concat(
		UserInfoOwner.Name, ' ', UserInfoOwner.Family
	) AS OwnerName,
	concat(
		UserInfoworker.Name, ' ', UserInfoworker.Family
	) AS workername,
	UserCredit.CreditMod AS CreditMod,
	UserCreditModMeta.ModName AS ModName,
	UserCredit.Type AS Type
from
	(
		(
			(
				(
					(
						UserCredit
						join RelatedStaff on(
							(
								UserCredit.ReferenceId = RelatedStaff.RelatedCredite
							)
						)
					)
					join RespnsType on(
						(
							RespnsType.ID = RelatedStaff.RespnsType
						)
					)
				)
				join UserInfo UserInfoOwner on(
					(
						UserInfoOwner.UserName = RelatedStaff.OwnerUserID
					)
				)
			)
			join UserInfo UserInfoworker on(
				(
					UserInfoworker.UserName = RelatedStaff.ResponserID
				)
			)
		)
		join UserCreditModMeta on(
			(
				UserCredit.CreditMod = UserCreditModMeta.ID
			)
		)
	)
group by
	ReportConfirmdate,RespnsTypeName,RelatedCredite,OwnerName,workername,CreditMod,ModName,Type
order by
	RespnsType.RespnsTypeName
         ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tafzili_reports');
    }
}
