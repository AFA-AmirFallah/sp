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
        Schema::table('crawl_datas', function (Blueprint $table) {
            $table->text('og_site_name')->after('TargetAddress')->nullable();
            $table->text('og_description')->after('TargetAddress')->nullable();
            $table->text('og_title')->after('TargetAddress')->nullable();
            $table->string('og_type',50)->after('TargetAddress')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     * 
     */
    public function down(): void
    {
        Schema::table('crawl_datas', function (Blueprint $table) {
            //
        });
    }
};
