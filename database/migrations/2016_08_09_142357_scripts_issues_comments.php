<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ScriptsIssuesComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('scripts_issues_comments', function(Blueprint $table)
        {
            $table->increments('id');
			$table->integer('issue_id')->unsigned()->index();
			$table->integer('user_id')->unsigned()->index();
			$table->text('text');
            $table->timestamps();
			$table->foreign('issue_id')->references('id')->on('scripts_issues')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::drop('scripts_issues_comments');
    }
}
