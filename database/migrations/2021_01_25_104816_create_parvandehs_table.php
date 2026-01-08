<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParvandehsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Parvandeh', function (Blueprint $table) {
            $table->bigInteger('ParvandehID');
            $table->integer('SubParvandehID');
            $table->string('owner', 20);
            $table->integer('branch');
            $table->integer('status')->default(0);
            $table->string('creator', 20);
            $table->bigInteger('form_id');
            $table->text('html_content');
            $table->text('fields_content');
            $table->text('extra')->nullable();
            $table->smallInteger('Type')->unsigned();
            $table->timestamps();
            $table->primary(['ParvandehID', 'SubParvandehID']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Parvandeh');
    }
}
