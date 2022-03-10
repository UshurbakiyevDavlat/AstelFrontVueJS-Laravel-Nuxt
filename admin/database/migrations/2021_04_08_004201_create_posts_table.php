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

            $table->date('published_at')->nullable();
            $table->tinyInteger('status')->default(PUBLISHED);

            $table->string('image')->nullable();
            $table->string('slug')->index();

            $table->json('name')->nullable();
            $table->json('description')->nullable();

            $table->json('content')->nullable();
            $table->json('seo')->nullable();

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
