<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTagsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tags', function(Blueprint $table) {
			$table->string('id', 36)->primary();
			$table->string('household_id', 36)->index();
			$table->string('user_id', 36)->index(); //owner
			$table->string('name', 100);
			$table->string('color', 7);

			$table->string('tagable_id',36)->index();
			$table->string('tagable_type');

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
		Schema::drop('tags');
	}

}
