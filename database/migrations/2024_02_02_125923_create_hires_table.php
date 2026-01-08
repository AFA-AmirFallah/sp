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
        Schema::create('hires', function (Blueprint $table) {
            $table->id();
            $table->string('owner',20)->index();
            $table->string('title',512)->index();
            $table->integer('type')->index();
            $table->integer('expertise')->index();
            $table->integer('status')->index();
            $table->integer('min_salary')->default(0)->index();
            $table->integer('max_salary')->default(0)->index();
            $table->integer('province_id')->index();
            $table->integer('city_id')->index();
            $table->integer('apply_count')->default(0);
            $table->integer('accept_count')->default(0);
            $table->text('description')->nullable();
            $table->text('meta_data')->nullable();
            $table->string('confirm_by',20)->nullable();
            $table->DateTime('confirm_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hires');
    }
};
