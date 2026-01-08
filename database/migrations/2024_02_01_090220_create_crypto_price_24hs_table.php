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
        Schema::create('crypto_price_24hs', function (Blueprint $table) {
            $table->string('candate', 10)->index();
            $table->string('curency', 30)->index();
            $table->string('OpenPrice', 30);
            $table->string('ClosePrice', 30);
            $table->string('HighPrice', 30);
            $table->string('LowPrice', 30);
            $table->string('TransVol', 30)->nullable();
            $table->string('TransAmo', 30)->nullable();
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
     */
    public function down(): void
    {
        Schema::dropIfExists('crypto_price_24hs');
    }
};
