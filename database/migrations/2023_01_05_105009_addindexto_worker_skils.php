<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddindextoWorkerSkils extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('WorkerSkils', function (Blueprint $table) {
            $table->integer('L2ID')->after('SkilID')->nullable();
            $table->integer('L1ID')->after('SkilID')->nullable();
            $table->integer('WorkCat')->after('SkilID')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('WorkerSkils', function (Blueprint $table) {
            //
        });
    }
}
