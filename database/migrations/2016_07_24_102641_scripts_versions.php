<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ScriptsVersions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('scripts_versions', function(Blueprint $table)
        {
            $table->increments('id');
			$table->integer('script_id')->unsigned()->index();
            $table->string('name');
			$table->text('changes');
            $table->timestamps();
			$table->foreign('script_id')->references('id')->on('scripts')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('scripts_versions');
    }
}
