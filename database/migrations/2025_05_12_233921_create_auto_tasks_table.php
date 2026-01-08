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
        Schema::create('auto_tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('auto_group_id');
            $table->string('title',255)->index();
            $table->integer('progress')->default(0)->index();
            $table->dateTime('reminder')->nullable()->index();
            $table->dateTime('deadline')->nullable()->index();
            $table->text('description')->nullable();
            $table->integer('status')->index();
            $table->unsignedBigInteger('up_task')->nullable()->index();
            $table->foreign('auto_group_id')->references('id')->on('auto_group');
            $table->string('creator',20)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auto_tasks');
    }
};
