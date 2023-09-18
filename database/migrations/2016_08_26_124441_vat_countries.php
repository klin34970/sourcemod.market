<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VatCountries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('vat_countries', function(Blueprint $table)
        {
            $table->increments('id');
			$table->string('country_code');
			$table->double('tax_super_low');
			$table->double('tax_low');
            $table->double('tax_normal');
			$table->double('tax_parking');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::drop('vat_countries');
    }
}
