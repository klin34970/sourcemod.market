<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ScriptsDiscussions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('scripts_discussions', function(Blueprint $table)
        {
            $table->increments('id');
			$table->integer('script_id')->unsigned()->index();
			$table->integer('user_id')->unsigned()->index();
            $table->text('text');
            $table->timestamps();
			$table->foreign('script_id')->references('id')->on('scripts')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::drop('scripts_discussions');
    }
}
