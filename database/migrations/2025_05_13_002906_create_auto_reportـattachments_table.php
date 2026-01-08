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
        Schema::create('auto_reportـattachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('report_id')->nullable()->index();
            $table->text('attach_refrence');
            $table->string('creator',20)->index();
            $table->foreign('report_id')->references('id')->on('auto_tasks_reports');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auto_reportـattachments');
    }
};
