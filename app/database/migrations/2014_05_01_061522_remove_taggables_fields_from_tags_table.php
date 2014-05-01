<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveTaggablesFieldsFromTagsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tags', function($table)
		{
		    $table->dropColumn('tagable_id');
		    $table->dropColumn('tagable_type');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tags', function($table)
		{
		    $table->string('tagable_id',36)->index();
			$table->string('tagable_type');
		});
	}

}
