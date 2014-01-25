<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecipesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('recipes', function(Blueprint $table) {
			$table->string('id', 36)->primary();
			$table->string('user_id', 36); //author
			$table->string('name');
			$table->text('description');
			$table->text('instructions');
			$table->text('picture_id', 36);
			$table->integer('number_of_portions');
			$table->string('preparation_time');
			$table->string('cooking_time');
			$table->softDeletes();
			$table->timestamps();
		});

		/** many to many relation table to categories table */
		Schema::create('recipes_categories', function(Blueprint $table){
			$table->string('recipe_id', 36);
			$table->string('category_id', 36);

			$table->unique(array('recipe_id', 'category_id'));
		});

		// /** many to many relation table to tags */
		// Schema::create('recipes_tags', function(Blueprint $table){
		// 	$table->string('recipe_id', 36);
		// 	$table->string('tag_id', 36);

		// 	$table->unique(array('recipe_id', 'tag_id'));
		// });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('recipes');
		Schema::drop('recipes_categories');
		Schema::drop('recipes_tags');
	}

}
