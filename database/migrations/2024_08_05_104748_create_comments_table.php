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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('service',255);
            $table->string('Name',255)->index();
            $table->string('code',10)->index();
            $table->string('MobileNo',20)->index();
            $table->string('related_person',20)->index();
            $table->string('creator',20)->index();
            $table->string('center_name',255)->nullable();
            $table->string('center_id',20)->nullable()->index();
            $table->string('confirm_by',20)->index()->nullable();
            $table->dateTime('confirm_date')->nullable();
            $table->integer('status')->index()->default(0);
            $table->text('comment');
            $table->text('indexes');
            $table->boolean('recommend');
            $table->boolean('call_allow');
            $table->boolean('show_info');
            $table->integer('rate');
            $table->integer('weight')->default(0);
            $table->text('history');
            $table->text('report')->nullable();
            $table->text('extra_info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
