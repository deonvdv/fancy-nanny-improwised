<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTodosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('todos', function(Blueprint $table) {
			$table->string('id')->primary();
			$table->string('household_id', 36);
			$table->string('user_id', 36);
			$table->string('title', 50);
			$table->text('description');
			$table->date('due_date');
			$table->string('assigned_by', 36);
			$table->string('assigned_to', 36);
			$table->boolean('is_complete');
			$table->string('notify');
			$table->integer('minutes_before');
			
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
		Schema::drop('todos');
	}

}
