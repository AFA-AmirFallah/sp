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
        Schema::table('html_objects', function (Blueprint $table) {
            $table->integer('branch')->before('created_at')->default(1)->index();
        });
        Schema::table('mobile_banner', function (Blueprint $table) {
            $table->integer('branch')->before('created_at')->default(1)->index();
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->integer('branch')->before('created_at')->default(1)->index();
        });
        Schema::table('deal_file', function (Blueprint $table) {
            $table->integer('branch')->before('created_at')->default(1)->index();
        });

    }


};
