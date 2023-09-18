<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Faq extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('faq', function(Blueprint $table)
        {
            $table->increments('id');
			$table->integer('category_id')->unsigned()->index();
			$table->text('text');
            $table->timestamps();
			$table->foreign('category_id')->references('id')->on('faq_categories')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('faq');
    }
}
