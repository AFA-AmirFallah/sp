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
        Schema::create('product_markeds', function (Blueprint $table) {
            $table->string('UserName',20)->index();
            $table->unsignedBigInteger('product_id')->index();
            $table->integer('mark_type')->index();
            $table->text('history')->nullable();

            $table->primary(['UserName', 'product_id','mark_type']);
            $table->foreign('product_id')->references('id')->on('goods');
            $table->foreign('UserName')->references('UserName')->on('UserInfo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_markeds');
    }
};
