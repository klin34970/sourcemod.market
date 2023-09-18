<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Scripts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('scripts', function(Blueprint $table)
        {
            $table->increments('id');
			$table->integer('user_id')->unsigned()->index();
            $table->string('title');
            $table->string('description');
            $table->double('price');
			$table->double('price_discount');
			$table->bool('activated');
            $table->timestamps();
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
		Schema::drop('scripts');
    }
}
