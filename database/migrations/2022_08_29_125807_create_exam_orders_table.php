<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_orders', function (Blueprint $table) {
            $table->id();
            $table->string('CustomerId',20);
            $table->integer('status')->default(0);
            $table->integer('exam_id');
            $table->integer('unit_Price')->default(0);
            $table->integer('unit_sales')->default(0);
            $table->integer('tax_total')->default(0);
            $table->integer('customer_benefit_total')->default(0);
            $table->integer('net_total')->default(0);
            $table->text('status_history')->nullable();
            $table->text('exam_checklist')->nullable();
            $table->text('exam_result')->nullable();
            $table->text('exam_extra_result')->nullable();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->string('confirmer',20)->nullable();
            $table->dateTime('confirm_time')->nullable();
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
        Schema::dropIfExists('exam_orders');
    }
}
