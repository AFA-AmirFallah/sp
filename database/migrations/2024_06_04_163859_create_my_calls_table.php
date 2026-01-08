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
        Schema::create('my_calls', function (Blueprint $table) {
            $table->id();
            $table->string('caller',20)->index();
            $table->string('call_number',11)->index();
            $table->string('answer_username',20)->index()->nullable();
            $table->string('callid',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('my_calls');
    }
};
