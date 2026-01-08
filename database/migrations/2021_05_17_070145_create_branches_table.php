<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('Name','100');
            $table->string('UserName','20');
            $table->string('Description','255');
            $table->string("Phone",'11');
            $table->string("Phone1",'11')->nullable();
            $table->string("Phone2",'11')->nullable();
            $table->string("Phone3",'11')->nullable();
            $table->text("license")->nullable();
            $table->text("avatar")->nullable();
            $table->integer("BranchType")->nullable();
            $table->integer("Index")->nullable();
            $table->date("Expire")->nullable();
            $table->string('api','100')->nullable();
            $table->string("Ext",'10')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branches');
    }
}
