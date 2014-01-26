<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecipeReviewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('recipe_reviews', function(Blueprint $table) {
			$table->string('id', 36)->primary();
			$table->string('recipe_id', 36)->index();
			$table->string('user_id', 36)->index();
			$table->smallInteger('score');
			$table->text('review');
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
		Schema::drop('recipe_reviews');
	}

}
