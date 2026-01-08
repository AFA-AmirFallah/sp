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
        Schema::table('UserInfo', function (Blueprint $table) {
            $table->decimal('long', 10, 7)->after('Ext')->nullable();
            $table->decimal('lat', 10, 7)->after('Ext')->nullable();
            $table->integer('city')->after('Ext')->index()->nullable();
            $table->integer('province')->after('Ext')->index()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('UserInfo', function (Blueprint $table) {
            //
        });
    }
};
