<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePicturesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pictures', function(Blueprint $table) {
			$table->string('id')->primary();
			$table->string('owner_id', 36)->index();
			$table->string('name', 255);
			$table->string('file_name', 255);
			$table->text('cdn_url');

			$table->string('imageable_id',36)->index();
			$table->string('imageable_type');

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
		Schema::drop('pictures');
	}

}
