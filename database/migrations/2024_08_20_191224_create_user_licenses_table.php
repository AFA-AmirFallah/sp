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
        Schema::create('user_licenses', function (Blueprint $table) {
            $table->id();
            $table->string('UserName', 20)->index();
            $table->string('license', 20)->index();
            $table->string('name', 255);
            $table->unsignedBigInteger('credit_reference');
            $table->dateTime('expire')->index();
            $table->integer('lic_count')->nullable();
            $table->text('extra_data')->nullable();
            $table->text('history')->nullable();
            $table->foreign('credit_reference')->references('ID')->on('UserCredit');
            $table->foreign('UserName')->references('UserName')->on('UserInfo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_licenses');
    }
};
