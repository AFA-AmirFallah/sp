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
        Schema::create('auto_tasksـattachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id')->nullable()->index();
            $table->text('attach_refrence');
            $table->string('creator',20)->index();
            $table->foreign('task_id')->references('id')->on('auto_tasks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auto_tasksـattachments');
    }
};
