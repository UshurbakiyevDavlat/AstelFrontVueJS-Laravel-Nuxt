<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->tinyInteger('status')->default(PUBLISHED);
            $table->date('published_at')->nullable();

            $table->string('image')->nullable();
            $table->json('images')->nullable();
            $table->string('slug')->index();

            $table->json('name')->nullable();
            $table->json('labels')->nullable();
            $table->json('description')->nullable();

            $table->json('content')->nullable();
            $table->json('seo')->nullable();

            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('lft')->unsigned()->nullable();
            $table->integer('rgt')->unsigned()->nullable();
            $table->integer('depth')->unsigned()->nullable();


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
        Schema::dropIfExists('projects');
    }
}
