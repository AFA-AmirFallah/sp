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
        Schema::create('statistic_datas', function (Blueprint $table) {
            $table->id();
            $table->integer('main_id')->index();
            $table->integer('item_id')->index();
            $table->dateTime('index_date')->index();
            $table->integer('open_value')->default(0);
            $table->integer('close_value')->default(0);
            $table->integer('one_value')->default(0);
            $table->integer('high_value')->default(0);
            $table->integer('low_value')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistic_datas');
    }
};
