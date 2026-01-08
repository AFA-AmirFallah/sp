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
        Schema::create('auto_tasksـtags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id')->nullable()->index();
            $table->unsignedBigInteger('tag_id')->nullable()->index();
            $table->foreign('task_id')->references('id')->on('auto_tasks');
            $table->foreign('tag_id')->references('id')->on('auto_tasksـtags_metas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auto_tasksـtags');
    }
};
