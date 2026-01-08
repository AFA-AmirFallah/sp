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
        Schema::table('DeviceContract', function (Blueprint $table) {
            $table->integer('tashim')->after('ExpireDate')->index()->nullable();
            $table->text('extra_data')->after('Note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('DeviceContract', function (Blueprint $table) {
            //
        });
    }
};
