<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropIngredientsRecipeingredientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if( Schema::hasTable('ingredients_recipeingredients')){
			Schema::drop('ingredients_recipeingredients');
		}		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::create('ingredients_recipeingredients', function(Blueprint $table) {
			$table->string('ingedrient_id', 36)->index();
			$table->string('recipe_ingredient_id', 36)->index();

			// $table->unique(array('ingedrient_id', 'recipe_ingredient_id'));
		});
	}

}
