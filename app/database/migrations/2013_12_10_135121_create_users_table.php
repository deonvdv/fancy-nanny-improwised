<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->string('id', 36)->primary();
			$table->string('household_id', 36);
			$table->string('name', 100);
			$table->string('email', 100)->unique();
			$table->string('password', 128);
			$table->string('street');
			$table->string('city', 100);
			$table->string('state', 50);
			$table->string('zip', 20);
			$table->string('country', 50);
			$table->string('home_number', 30);
			$table->string('work_number', 30);
			$table->enum('role', array('admin', 'parent', 'guardian', 'child', 'staff'));
			$table->boolean('active');
			$table->string('profile_picture');
			$table->text('app_settings');
			
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
		Schema::drop('users');
	}

}
