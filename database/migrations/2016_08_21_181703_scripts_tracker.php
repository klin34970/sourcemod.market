<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ScriptsTracker extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scripts_tracker', function(Blueprint $table)
        {
            $table->increments('id');
			$table->integer('game_id')->unsigned()->index();
			$table->integer('script_id')->unsigned()->index();
			$table->integer('script_version_id')->unsigned()->index();
			$table->integer('purchaser_id')->unsigned()->index();
			$table->string('hostname');
			$table->string('ip');
			$table->integer('port');
            $table->timestamps();
			$table->foreign('game_id')->references('id')->on('games')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('script_id')->references('id')->on('scripts')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('script_version_id')->references('id')->on('scripts_versions')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('scripts_tracker');
    }
}
