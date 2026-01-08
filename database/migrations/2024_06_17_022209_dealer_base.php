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
        Schema::create('deal_product_type', function (Blueprint $table) {
            $table->id();
            $table->string('Name', 50)->index();
            $table->timestamps();
        });
        Schema::create('deal_file', function (Blueprint $table) {
            $table->id();
            $table->string('creator', 20)->index(); // file creator
            $table->string('owner', 20)->index(); // deal owner
            $table->string('title', 255); 
            $table->text('description')->nullable();
            $table->unsignedBigInteger('min_price')->nullable();
            $table->unsignedBigInteger('max_price')->nullable();
            $table->string('show_price', 255);
            $table->text('dealer_note')->nullable();
            $table->unsignedBigInteger('product_type')->index(); // kamiyon kamiyounet keshande otagh kafi
            $table->string('pelak', 255)->nullable();
            $table->string('vin', 255)->nullable();
            $table->integer('deal_type')->index();
            $table->integer('status')->index();
            $table->integer('location')->default(0);
            $table->integer('view')->default(0);
            $table->integer('like')->default(0);
            $table->text('properties');
            $table->text('actions');
            $table->text('logs')->nullable();
            $table->foreign('product_type')->references('id')->on('deal_product_type');
            $table->timestamps();
        });
        Schema::create('deal_file_dealers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('deal_file');
            $table->string('UserName', 20);
            $table->foreign('deal_file')->references('id')->on('deal_file');
            $table->foreign('UserName')->references('UserName')->on('UserInfo');
            $table->timestamps();
        });
        Schema::create('deal_file_pic', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('deal_file');
            $table->foreign('deal_file')->references('id')->on('deal_file');
            $table->text('pic');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deal_product_type');
        Schema::dropIfExists('deal_file');
        Schema::dropIfExists('deal_file_dealers');
        Schema::dropIfExists('deal_file_pic');
    }
};
