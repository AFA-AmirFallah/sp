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
        Schema::create('statistic_mains', function (Blueprint $table) {
            $table->id();
            $table->string('Name',255);
            $table->integer('period');//period min
            $table->integer('type');
            $table->integer('branch')->default(1)->index();
            $table->integer('post')->index();
            $table->integer('status')->index()->default(0);
            $table->text('desc')->nullable();
            $table->text('more_info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistic_mains');
    }
};
