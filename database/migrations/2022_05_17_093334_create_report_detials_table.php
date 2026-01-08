<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportDetialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_detials', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ProductID')->nullable();
            $table->string('UserID',20)->nullable();
            $table->bigInteger('WGID')->nullable();
            $table->integer('ReportType');
            $table->text('ReportVal')->nullable();
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
        Schema::dropIfExists('report_detials');
    }
}
