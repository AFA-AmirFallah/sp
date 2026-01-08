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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->string('owner',20)->index();
            $table->integer('request_job')->index();
            $table->integer('status')->index();
            $table->string('owner_extra_note')->nullable();
            $table->boolean('owner_alert')->default(0);
            $table->boolean('employer_alert')->default(0);
            $table->text('report')->nullable();
            $table->text('workflow')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
