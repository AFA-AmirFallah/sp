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
        Schema::create('statistic_items', function (Blueprint $table) {
            $table->id();
            $table->integer('main_id')->index();
            $table->integer('row_number')->index();
            $table->string('item_name', 255);
            $table->string('item_index_str', 255)->nullable();
            $table->integer('item_index_number')->nullable();
            $table->text('item_description')->nullable();
            $table->text('item_picture')->nullable();
            $table->text('direct_link')->nullable();
            $table->integer('related_post')->index()->nullable();
            $table->integer('status')->index()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistic_items');
    }
};
