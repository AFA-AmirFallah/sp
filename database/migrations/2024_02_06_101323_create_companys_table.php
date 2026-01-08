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
        Schema::create('companys', function (Blueprint $table) {
            $table->id();
            $table->string('UserName',20)->index();
            $table->string('Name',255)->index();
            $table->string('MobileNo',11);
            $table->string('NationalCode',20)->nullable(); 
            $table->string('ShSh',20)->nullable();
            $table->string('Email',255)->nullable();
            $table->string('website',255)->nullable();
            $table->string('Phone1',20)->nullable();
            $table->string('Phone2',20)->nullable();
            $table->integer('working_index')->index();
            $table->integer('province')->index();
            $table->integer('city')->index();
            $table->text('Address')->nullable();
            $table->integer('CreateDate')->nullable();;
            $table->tinyInteger('Status');
            $table->string('type',1)->nullable();
            $table->text('avatar')->nullable();
            $table->text('description')->nullable();
            $table->text('extranote')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companys');
    }
};
