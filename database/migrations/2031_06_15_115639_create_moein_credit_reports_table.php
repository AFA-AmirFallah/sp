<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoeinCreditReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE ALGORITHM=UNDEFINED  VIEW MoeinCreditReports AS
        select
	cast(UserCredit.Confirmdate as Date) AS ReportConfirmdate,
	RespnsType.RespnsTypeName AS RespnsTypeName,
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
	UserCredit.CreditMod AS CreditMod,
	UserCreditModMeta.ModName AS CreditModName
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
	ReportConfirmdate,
	RespnsTypeName,
	CreditMod,
	CreditModName

order by
	ReportConfirmdate
        ");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('MoeinCreditReports');
    }
}
