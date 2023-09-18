<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ScriptsVersionsDownloads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('scripts_versions_downloads', function(Blueprint $table)
        {
            $table->increments('id');
			$table->integer('version_id')->unsigned()->index();
			$table->integer('user_id')->unsigned()->index();
            $table->timestamps();
			$table->foreign('version_id')->references('id')->on('scripts_versions')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::drop('scripts_versions_downloads');
    }
}
