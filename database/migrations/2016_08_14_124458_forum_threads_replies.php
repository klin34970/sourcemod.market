<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForumThreadsReplies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('forum_threads_replies', function(Blueprint $table)
        {
            $table->increments('id');
			$table->integer('thread_id')->unsigned()->index();
			$table->integer('user_id')->unsigned()->index();
			$table->text('text');
            $table->timestamps();
			$table->foreign('thread_id')->references('id')->on('forum_threads')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::drop('forum_threads_replies');
    }
}
