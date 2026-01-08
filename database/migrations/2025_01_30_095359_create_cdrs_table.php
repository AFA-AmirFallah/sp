<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cdrs', function (Blueprint $table) {
            $table->id();
            $table->dateTime('calldate')->index();
            $table->string('clid', 80)->nullable()->index();
            $table->string('src', 80)->nullable()->index();
            $table->string('dst', 80)->nullable()->index();
            $table->string('dcontext', 80)->nullable()->index();
            $table->string('channel', 80)->nullable();
            $table->string('dstchannel', 80)->nullable();
            $table->string('lastapp', 80)->nullable()->index();
            $table->string('lastdata', 80)->nullable()->index();
            $table->integer('duration')->index();
            $table->integer('billsec')->index();
            $table->string('disposition', 45)->index();
            $table->integer('amaflags')->index();
            $table->string('accountcode', 20)->nullable();
            $table->string('uniqueid', 32)->index();
            $table->string('userfield', 255)->nullable();
            $table->string('recordingfile', 255)->nullable();
            $table->string('cnum', 40)->nullable()->index();
            $table->string('cnam', 40)->nullable()->index();
            $table->string('outbound_cnum', 40)->nullable()->index();
            $table->string('outbound_cnam', 40)->nullable()->index();
            $table->string('dst_cnam', 40)->nullable()->index();
            $table->string('did', 40)->nullable()->index();
            $table->string('answer', 25)->nullable()->index();
            $table->string('related_user', 25)->nullable()->index();
            $table->boolean('sms_flag')->nullable()->index();
            $table->boolean('important_flag')->nullable()->index();
            $table->boolean('todo_flag')->nullable()->index();
            $table->text('more_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cdrs');
    }
};
