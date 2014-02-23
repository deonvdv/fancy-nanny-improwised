<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropRecipesCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(Schema::hasTable('recipes_categories')){
			Schema::drop('recipes_categories');
		}		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::create('recipes_categories', function(Blueprint $table){
			$table->string('recipe_id', 36)->index();
			$table->string('category_id', 36)->index();

			$table->unique(array('recipe_id', 'category_id'));
		});
	}

}
