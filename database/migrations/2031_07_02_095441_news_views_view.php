<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewsViewsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE ALGORITHM=UNDEFINED  VIEW news_views_view AS
       SELECT Post,Status,COUNT(Status) as views_count FROM post_views GROUP by Post,Status ");
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_views_view');
    }
}
