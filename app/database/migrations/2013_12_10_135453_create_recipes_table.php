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
			$table->string('author_id', 36)->index(); //author
			$table->string('name')->index();
			$table->text('description');
			$table->text('instructions');
			$table->integer('number_of_portions');
			$table->time('preparation_time');
			$table->time('cooking_time');
			$table->softDeletes();
			$table->timestamps();
		});

		/** many to many relation table to categories table */
		Schema::create('recipes_categories', function(Blueprint $table){
			$table->string('recipe_id', 36)->index();
			$table->string('category_id', 36)->index();

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
		// Schema::drop('recipes_tags');
	}

}
