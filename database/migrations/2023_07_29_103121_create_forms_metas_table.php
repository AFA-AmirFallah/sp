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
        Schema::create('forms_metas', function (Blueprint $table) {
            $table->id();
            $table->string('title', 300);
            $table->string('up_title', 300)->nullable();
            $table->string('sub_title', 300)->nullable();
            $table->text('Pic')->nullable();
            $table->text('Content');
            $table->text('PostContent')->nullable();
            $table->text('Lead')->nullable();
            $table->text('Abstract')->nullable();
            $table->string('Creator', 20);
            $table->string('Owner', 20)->nullable();
            $table->smallInteger('Status');
            $table->smallInteger('Type');
            $table->smallInteger('UserAccessLevel')->default(0);
            $table->text('UserAccessIndex')->nullable();
            $table->smallInteger('AdminAccessLevel')->default(0);
            $table->text('AdminAccessIndex')->nullable();
            $table->integer("Price")->nullable();
            $table->integer("CreatorPrice")->nullable();
            $table->text('CoverPage')->nullable();
            $table->integer("branch");
            $table->timestamps();

        });
    }
    public function down(): void
    {
        Schema::dropIfExists('forms_metas');
    }
};
