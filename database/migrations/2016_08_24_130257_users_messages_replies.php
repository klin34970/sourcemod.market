<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersMessagesReplies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_messages_replies', function(Blueprint $table)
        {
            $table->increments('id');
			$table->integer('message_id')->unsigned()->index();
			$table->text('text');
            $table->timestamps();
			$table->foreign('message_id')->references('id')->on('users_messages')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::drop('users_messages_replies');
    }
}
