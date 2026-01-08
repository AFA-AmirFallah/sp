<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrawlDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crawl_datas', function (Blueprint $table) {
            $table->id();
            $table->string('Name',255)->nullable();
            $table->integer('CrawlID');
            $table->text('TargetAddress');
            $table->text('TargetData')->nullable();
            $table->text('DataHistory')->nullable();
            $table->string('SourceDate',250);
            $table->integer('Status');
            $table->integer('LocalProduct')->nullable();
            $table->integer('LocalWP')->nullable();
            $table->integer('LocalWarehouse')->nullable();
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
        Schema::dropIfExists('crawl_datas');
    }
}
