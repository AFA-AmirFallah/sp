<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemIndicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_index', function (Blueprint $table) {
            $table->id();
            $table->string('UserName', 20)->nullable();
            $table->integer('PostId')->nullable();
            $table->integer('IndexID');
            $table->integer('Status');
            $table->integer('Type');
            $table->text('Note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_index');
    }
}
