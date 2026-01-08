<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserWithSkillsView extends Migration
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
   VIEW `user_with_skills_view`
   AS select UserInfo.* , WorkerSkils.SkilID as SkilID  , WorkerSkils.WorkCat as WorkCat  , WorkerSkils.L1ID as L1ID  , WorkerSkils.L2ID as L2ID from UserInfo INNER JOIN WorkerSkils on WorkerSkils.UserName = UserInfo.UserName
      ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS user_with_skills_view');
    }
}
