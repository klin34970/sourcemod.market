<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JobsAppliers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('jobs_appliers', function(Blueprint $table)
        {
            $table->increments('id');
			$table->integer('job_id')->unsigned()->index();
			$table->integer('user_id')->unsigned()->index();
			$table->double('price');
            $table->text('text');
            $table->timestamps();
			$table->foreign('job_id')->references('id')->on('jobs')->onUpdate('cascade')->onDelete('cascade');
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
		Schema::drop('jobs_appliers');
    }
}
