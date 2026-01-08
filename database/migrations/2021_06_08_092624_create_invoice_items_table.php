<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->integer('InvoiceID');
            $table->integer('ItemID');
            $table->string('ItemName',100);
            $table->string('Unit','20');
            $table->integer('UnitPrice');
            $table->integer('Qty')->default(1);
            $table->integer('Discount');
            $table->integer('TotallPrice');
            $table->timestamps();
            $table->primary(['InvoiceID', 'ItemID']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_items');
    }
}
