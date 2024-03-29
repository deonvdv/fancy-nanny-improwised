<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecipeIngredientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('recipe_ingredients', function(Blueprint $table) {
			$table->string('id', 36)->primary();
			$table->string('recipe_id', 36)->index();
			$table->float('quantity');
			$table->string('unit_of_measure_id', 36)->index();
			$table->string('ingredient_id', 36)->index();
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
		Schema::drop('recipe_ingredients');
	}

}
