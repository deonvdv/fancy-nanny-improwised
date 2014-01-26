<?php

use Illuminate\Database\Migrations\Migration;

class AddCategoryToRecipeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('recipes', function($table)
		{
		    $table->string('category_id', 36)->default('')->index();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('recipes', function($table)
		{
		    $table->dropColumn('category_id');
		});	
	}

}