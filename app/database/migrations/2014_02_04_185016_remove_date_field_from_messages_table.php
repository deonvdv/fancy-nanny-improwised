<?php

use Illuminate\Database\Migrations\Migration;

class RemoveDateFieldFromMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('messages', function($table)
		{
		    $table->dropColumn('date');
		});	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('messages', function($table)
		{
		    $table->date('date');
		});
	}

}