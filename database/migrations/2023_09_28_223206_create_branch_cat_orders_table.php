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
        Schema::create('branch_cat_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('catorder')->index();
            $table->integer('branch')->index();
            $table->text('MainDescription')->nullable();
            $table->integer('Status')->index();
            $table->boolean('OnSale')->index();
            $table->integer('max_price')->nullable();
            $table->integer('min_price')->nullable();
            $table->integer('used')->default(0);
            $table->integer('rank')->default(0);
            $table->text('extra_info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_cat_orders');
    }
};
