<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('auto_group_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('auto_group_id');
            $table->unsignedBigInteger('auto_role_id');
            $table->string('UserName',20);
            $table->foreign('auto_role_id')->references('id')->on('auto_roles');
            $table->foreign('UserName')->references('UserName')->on('UserInfo');
            $table->foreign('auto_group_id')->references('id')->on('auto_group');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
