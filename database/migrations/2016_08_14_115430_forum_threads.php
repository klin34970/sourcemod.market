<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForumThreads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('forum_threads', function(Blueprint $table)
        {
            $table->increments('id');
			$table->integer('forum_id')->unsigned()->index();
			$table->integer('user_id')->unsigned()->index();
			$table->string('title');
			$table->text('text');
            $table->timestamps();
			$table->foreign('forum_id')->references('id')->on('forum_forums')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('forum_threads');
    }
}
