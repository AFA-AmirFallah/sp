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
            $table->date('src_date')->after('SourceDate')->index()->nullable();
            $table->time('src_time')->after('SourceDate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('crawl_datas', function (Blueprint $table) {
            //
        });
    }
};
