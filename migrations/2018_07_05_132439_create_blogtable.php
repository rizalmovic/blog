<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogtable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('parent_id')->references('id')->on('blog_categories')->onDelete('set null');
        });

        Schema::create('blog_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->json('metas')->nullable();
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->text('description', 255)->nullable();
            $table->longText('content', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('blog_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->json('metas')->nullable();
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->text('description', 255)->nullable();
            $table->longText('content', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('blog_category_page', function (Blueprint $table) {
            $table->integer('category_id')->unsigned();
            $table->integer('page_id')->unsigned();
            $table->primary(['category_id', 'page_id']);

            $table->foreign('category_id')->references('id')->on('blog_categories')->onDelete('cascade');
            $table->foreign('page_id')->references('id')->on('blog_pages')->onDelete('cascade');
        });

        Schema::create('blog_category_post', function (Blueprint $table) {
            $table->integer('category_id')->unsigned();
            $table->integer('post_id')->unsigned();
            $table->primary(['category_id', 'post_id']);

            $table->foreign('category_id')->references('id')->on('blog_categories')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('blog_posts')->onDelete('cascade');
        });

        Schema::create('blog_revisions', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['create', 'update', 'delete', 'restore']);
            $table->string('batch', 255)->unique();
            $table->morphs('revisionable');
            $table->smallInteger('number')->default(0);
            $table->json('fields')->nullable();
            $table->json('prev_state')->nullable();
            $table->json('current_state')->nullable();
            $table->integer('author_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_category_post');
        Schema::dropIfExists('blog_category_page');
        Schema::dropIfExists('blog_posts');
        Schema::dropIfExists('blog_pages');
        Schema::dropIfExists('blog_categories');
        Schema::dropIfExists('blog_revisions');
    }
}
