<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('crawl_datas', function (Blueprint $table) {
            $table->text('price_history')->after('og_site_name')->nullable();
            $table->bigInteger('price')->after('og_site_name')->default(0)->index();
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
