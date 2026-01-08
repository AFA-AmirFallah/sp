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
        Schema::create('auto_tasks_items', function (Blueprint $table) {
            $table->id();
            $table->integer('order')->index();
            $table->unsignedBigInteger('task_id')->nullable()->index();
            $table->string('item',255);
            $table->integer('progress')->default(0)->index();
            $table->string('done_by',20)->nullable();
            $table->foreign('task_id')->references('id')->on('auto_tasks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auto_tasks_items');
    }
};
