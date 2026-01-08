<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddextraToUserInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('UserInfo', function (Blueprint $table) {
            $table->text('extradata')->after('extranote')->nullable();
            $table->integer('extraStatus')->after('extranote')->nullable();
            $table->string('UpTitel',300)->after('extranote')->nullable();
            $table->string('Titel',300)->after('extranote')->nullable();
            $table->string('SubTitel',300)->after('extranote')->nullable();
            $table->string('Pic',300)->after('extranote')->nullable();
            $table->string('CoverPic',300)->after('extranote')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('UserInfo', function (Blueprint $table) {
            //
        });
    }
}
