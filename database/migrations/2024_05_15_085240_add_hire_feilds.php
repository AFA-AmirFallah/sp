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
        Schema::table('hires', function (Blueprint $table) {
            $table->smallInteger('salary')->after('city_id')->index()->default(0);
            $table->smallInteger('job_level')->after('city_id')->index()->default(0);
            $table->smallInteger('age')->after('city_id')->index()->default(0);
            $table->smallInteger('edu')->after('city_id')->index()->default(0);
            $table->smallInteger('sex')->after('city_id')->index()->default(0);
            $table->smallInteger('sarbazi')->after('city_id')->index()->default(0);
            $table->boolean('padash')->after('sarbazi')->default(0);
            $table->boolean('amozesh')->after('sarbazi')->default(0);
            $table->boolean('vam')->after('sarbazi')->default(0);
            $table->boolean('beme')->after('sarbazi')->default(0);
            $table->boolean('varzesh')->after('sarbazi')->default(0);
            $table->boolean('pezeshk')->after('sarbazi')->default(0);
            $table->boolean('tafrih')->after('sarbazi')->default(0);
            $table->boolean('bon')->after('sarbazi')->default(0);
            $table->boolean('hadeye')->after('sarbazi')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
