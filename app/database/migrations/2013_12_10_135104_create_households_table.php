<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHouseholdsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('households', function(Blueprint $table) {
			$table->string('id', 36)->primary();
			$table->string('name');
			$table->text('emergency_contacts')->nullable();
			$table->text('critical_information')->nullable();
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
		Schema::drop('households');
	}

}
