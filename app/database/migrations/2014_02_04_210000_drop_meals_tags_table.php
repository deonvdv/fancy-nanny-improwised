<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropMealsTagsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(Schema::hasTable('meals_tags')){
			Schema::drop('meals_tags');
		}		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::create('meals_tags', function($table){
			$table->string('meal_id', 36);
			$table->string('tag_id', 36);

			$table->unique(array('meal_id', 'tag_id'));
		});
	}

}
