<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMealsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('meals', function(Blueprint $table) {
			$table->string('id', 36)->primary();
			$table->string('household_id', 36)->index();
			$table->smallInteger('week_number')->unsigned();
			$table->smallInteger('day_of_week')->unsigned();
			$table->enum('slot', array('breakfast', 'lunch', 'dinner'));
			$table->softDeletes();
			$table->timestamps();
		});

		/** many to many relation to recipes */
		Schema::create('meals_recipes', function($table){
			$table->string('meal_id', 36);
			$table->string('recipe_id', 36);

			$table->unique(array('meal_id', 'recipe_id'));
		});

	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('meals');
		Schema::drop('meals_recipes');
	}

}
