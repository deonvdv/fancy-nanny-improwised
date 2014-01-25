<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('events', function(Blueprint $table) {
			$table->string('id')->primary();
			$table->string('household_id', 36);
			$table->string('user_id', 36);
			$table->string('title', 50);
			$table->text('description');
			$table->string('location', 80);
			$table->date('event_date');
			$table->time('event_time');
			$table->boolean('all_day');
			$table->string('notify');
			$table->integer('minutes_before');
			$table->string('type', 20);

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
		Schema::drop('events');
	}

}
