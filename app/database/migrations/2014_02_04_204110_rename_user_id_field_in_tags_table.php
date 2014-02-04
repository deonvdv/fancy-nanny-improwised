<?php

use Illuminate\Database\Migrations\Migration;

class RenameUserIdFieldInTagsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tags', function($table)
		{
		    $table->renameColumn('user_id', 'owner_id');
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
		    $table->renameColumn('owner_id', 'user_id');
		});
	}

}