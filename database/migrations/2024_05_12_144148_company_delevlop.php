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
        Schema::table('companys', function (Blueprint $table) {
            $table->string('Name_en',12)->after('Name')->nullable();
            $table->string('industrial',255)->after('MobileNo')->nullable();
            $table->integer('industrial_int')->after('MobileNo')->nullable();
            $table->integer('size')->after('MobileNo')->nullable();
            $table->integer('ownership')->after('MobileNo')->nullable();
            $table->text('brands')->after('description')->nullable();
            $table->text('products')->after('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companys', function (Blueprint $table) {
            //
        });
    }
};
