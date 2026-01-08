<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkerSkilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('WorkerSkils', function (Blueprint $table) {
            $table->string('UserName', 20);
            $table->integer('SkilID');
            $table->date('CreateDate');
            $table->integer('Status');
            $table->text('Note');
            $table->timestamps();
            $table->primary(['UserName', 'SkilID']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('WorkerSkils');
    }
}
