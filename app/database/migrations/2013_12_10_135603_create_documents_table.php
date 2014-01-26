<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDocumentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('documents', function(Blueprint $table) {
			$table->string('id')->primary();
			$table->string('household_id', 36)->index();
			$table->string('owner_id', 36)->index();
			$table->string('name', 255);
			$table->string('file_name', 255);
			$table->text('cdn_url');
			$table->boolean('private');
			
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
		Schema::drop('documents');
	}

}
