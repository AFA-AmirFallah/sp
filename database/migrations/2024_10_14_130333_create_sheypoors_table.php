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
        Schema::create('sheypoors', function (Blueprint $table) {
            $table->id();
            $table->string('src_id',25)->index();
            $table->string('src_type',25)->index();
            $table->string('location',255)->index();
            $table->string('telephone',25)->index();
            $table->string('title',255)->index();
            $table->string('price',255)->index();
            $table->string('categoryname',255)->index();
            $table->integer('categoryId')->index();
            $table->text('description');
            $table->text('url');
            $table->text('fullAttributes');
            $table->text('images')->nullable();
            $table->integer('status')->default(0)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sheypoors');
    }
};
