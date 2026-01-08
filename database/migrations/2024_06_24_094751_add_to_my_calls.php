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
        Schema::table('my_calls', function (Blueprint $table) {
            $table->text('sms_text')->after('callid')->nullable();
            $table->text('extra_info')->after('callid')->nullable();
            $table->unsignedBigInteger('deal')->after('callid')->index()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('my_calls', function (Blueprint $table) {
            //
        });
    }
};
