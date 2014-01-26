<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUnitMeasuresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('units_of_measure', function(Blueprint $table) {
			$table->string('id', 36)->primary();
			$table->string('name', 50);
			$table->string('alias', 255);
			$table->string('preferred_alias', 50);
			$table->softDeletes();
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
		Schema::drop('units_of_measure');
	}

}
