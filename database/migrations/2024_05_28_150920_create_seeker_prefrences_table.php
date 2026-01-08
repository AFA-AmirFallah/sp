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
        Schema::create('seeker_prefrences', function (Blueprint $table) {
            $table->id();
            $table->string('UserName',20)->index();
            $table->smallInteger('hire_index_1')->index()->default(0);
            $table->smallInteger('hire_index_2')->index()->default(0);
            $table->smallInteger('hire_index_3')->index()->default(0);
            $table->smallInteger('province_id')->index()->default(0);
            $table->smallInteger('salary')->index()->default(0);
            $table->smallInteger('job_level')->index()->default(0);
            $table->smallInteger('age')->index()->default(0);
            $table->smallInteger('edu')->index()->default(0);
            $table->smallInteger('sex')->index()->default(0);
            $table->smallInteger('expertise')->index()->default(0);
            $table->smallInteger('type')->index()->default(1);
            $table->smallInteger('sarbazi')->index()->default(0);
            $table->boolean('padash')->index()->default(0);
            $table->boolean('amozesh')->index()->default(0);
            $table->boolean('vam')->index()->default(0);
            $table->boolean('beme')->index()->default(0);
            $table->boolean('varzesh')->index()->default(0);
            $table->boolean('pezeshk')->index()->default(0);
            $table->boolean('tafrih')->index()->default(0);
            $table->boolean('bon')->index()->default(0);
            $table->boolean('hadeye')->index()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seeker_prefrences');
    }
};
