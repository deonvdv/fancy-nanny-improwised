<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecipeIngrendientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('recipe_ingrendients', function(Blueprint $table) {
			$table->string('id', 36)->primary();
			$table->string('recipe_id', 36);
			$table->float('quantity');
			$table->string('unit_measure_id', 36);
			$table->string('ingrendient_id', 36);
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
		Schema::drop('recipe_ingrendients');
	}

}
