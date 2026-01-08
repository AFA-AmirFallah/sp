<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountingReportViewsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$Daramad =  'daramad';
		DB::statement("CREATE ALGORITHM=UNDEFINED  VIEW `AccountingReportView` AS
select
	cast(UserCredit.Confirmdate as date) AS Confirmdate,
	RespnsType.RespnsTypeName AS RespnsTypeName,
	sum(
		(
			case when (
				(UserCredit.Mony < 0)
				and (UserCredit.UserName <> '$Daramad')
			) then (
				UserCredit.Mony * -(1)
			) else 0 end
		)
	) AS input,
	sum(
		(
			case when (
				(UserCredit.Mony > 0)
				and (UserCredit.UserName <> '$Daramad')
			) then UserCredit.Mony else 0 end
		)
	) AS output,
	sum(
		(
			case when (UserCredit.UserName = '$Daramad') then UserCredit.Mony else 0 end
		)
	) AS daramad,
	cast(UserCredit.Confirmdate as date) AS cdate,
	count(0) AS Mycount,
	UserCredit.CreditMod AS creditmode,
	UserCreditModMeta.ModName AS ModName,
	(
		cast(UserCredit.Confirmdate as date) - curdate()
	) AS PastDate,
	RespnsType.ID AS ID,
	RespnsType.UserCreditIndex AS UserCreditIndex,
	UserCredit.Type AS Type
from
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
		join UserCreditModMeta on(
			(
				UserCredit.CreditMod = UserCreditModMeta.ID
			)
		)
	)
group by
	Confirmdate,
	RespnsTypeName,
	cdate,
	creditmode,
	ModName,
	PastDate,
	ID,
	UserCreditIndex,
	Type");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('AccountingReportView');
	}
}
