<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('UpTitel', 300)->nullable();
            $table->string('Titel', 300);
            $table->string('SubTitel', 300)->nullable();
            $table->string('Name', 300);
            $table->string('LinkAddress', 300);
            $table->string('MainPic', 300)->nullable();
            $table->string('SecondPic', 300)->nullable();
            $table->string('titlePic', 300)->nullable();
            $table->string('Pic', 300)->nullable();
            $table->text('Content');
            $table->text('PostContent')->nullable();
            $table->text('Lead');
            $table->text('Abstract')->nullable();
            $table->string('Creator', 20);
            $table->string('Writer', 20);
            $table->smallInteger('Status');
            $table->smallInteger('Type');
            $table->integer("paernt")->default(0);
            $table->integer("CommentCount")->default(0);
            $table->integer("LikeCount")->default(0);
            $table->integer("ViewCount")->default(0);
            $table->smallInteger("hotnews")->default(0);
            $table->smallInteger("adds")->default(0);
            $table->smallInteger("article")->default(0);
            $table->smallInteger("galery")->default(0);
            $table->integer("MainIndex")->nullable();
            $table->smallInteger('TitleAccessLevel')->default(0);
            $table->smallInteger('ContentAccessLevel')->default(0);
            $table->boolean('Newsletter')->default(false);
            $table->integer("Price")->nullable();
            $table->integer("CreatorPrice")->nullable();
            $table->string('ExtWriter', 300)->nullable();
            $table->string('ExtTranslater', 300)->nullable();
            $table->string('RefName', 300)->nullable();
            $table->text('RefLink')->nullable();
            $table->text('OutLink')->nullable();
            $table->text('CoverPage')->nullable();
            $table->text('Related')->nullable();
            $table->date("CrateDate");
            $table->integer("mostview")->default(0);
            $table->integer("mini")->default(0);
            $table->integer("larg")->default(0);
            $table->integer("lastnews")->default(0);
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
        Schema::dropIfExists('posts');
    }
}
