<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::statement("CREATE ALGORITHM=UNDEFINED  VIEW order_view AS SELECT addorder1.ID,addorder1.UserName,addorder1.BimarUserName,addorder1.CatID,addorder1.CreateDate,addorder1.Status,addorder1.branch,addorder1.suggest_time,addorder1.AttachFiles,addorder1.PearID,UserInfo.Name,UserInfo.Family,UserInfo.MobileNo,orderstatus.status as statusname from addorder1 INNER JOIN UserInfo on addorder1.UserName = UserInfo.UserName INNER JOIN orderstatus on addorder1.Status = orderstatus.ID
");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_views');
    }
}
