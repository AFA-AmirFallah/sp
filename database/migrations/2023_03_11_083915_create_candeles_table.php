<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandelesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candeles', function (Blueprint $table) {
            $table->date('candate')->index();
            $table->integer('curency')->index();
            $table->string('OpenPrice', 30);
            $table->string('ClosePrice', 30);
            $table->string('HighPrice', 30);
            $table->string('LowPrice', 30);
            $table->string('TransVol', 30);
            $table->string('TransAmo', 30);
            $table->float('Percent');
            $table->string('Avreage', 30)->nullable();
            $table->integer('status')->default(0)->index();
            $table->text('extrainfo')->nullable();
            $table->primary(['candate', 'curency']);
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
        Schema::dropIfExists('candeles');
    }
}
