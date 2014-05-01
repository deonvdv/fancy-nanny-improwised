<?php

use \Models;

class TodoTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanCreateTodoSaveRetrieveAndDelete()
	{
		
    	$faker = \Faker\Factory::create();
		
		//Get the user
		$user = parent::createFakeUser();

		$newtodo = parent::createFakeTodo( $user );

		// Set AssignedBy
		$newtodo->setAssignedBy( $user );
		
		// Set AssignedTo
		$newtodo->setAssignedTo( $user );

		$newtodo->minutes_before = 20;
		// var_dump( $newtodo->validate() );
		// var_dump( $newtodo->errors());
		$this->assertTrue( $newtodo->validate() );
		$newtodo->save();	
		$id = $newtodo->id;

		// Add Tags
		$tag1 = parent::createFakeTag( $user );
		$newtodo->addTag( $tag1 );

		$tag2 = parent::createFakeTag( $user );
		$newtodo->addTag( $tag2 );

		// Get remaining Todo
		$found = \Models\Todo::where('assigned_to', '=', $user->id)->remaining()->get();
		$this->assertTrue(count($found) == 1);
		$this->assertTrue($found[0]->id == $id);
		$this->assertTrue($found[0]->is_complete == 0);

		//Mark task completed
		$found[0]->is_complete = 1;
		$found[0]->save();

		// Get completed Todo
		$found = \Models\Todo::where('assigned_to', '=', $user->id)->completed()->get();
		$this->assertTrue(count($found) == 1);
		$this->assertTrue($found[0]->id == $id);
		$this->assertTrue($found[0]->is_complete == 1);

		// Get assignedto Todo
		$found = \Models\Todo::where('assigned_by', '=', $user->id)->get();
		$this->assertTrue(count($found) == 1);
		$this->assertTrue($found[0]->id == $id);
		
		//get Todo from database
		$found = \Models\Todo::with('tags')->where('id', '=', $id)->firstOrFail();
		// print_r($found);
		// echo "\nFound Id: " . $found->id . "\n";

		$this->assertTrue($found->id == $id);

		// Test Todo
		$this->assertTrue($found->id == $newtodo->id);
		$this->assertTrue($found->title == $newtodo->title);
		$this->assertTrue($found->owner->id == $newtodo->owner_id);
		$this->assertTrue($found->owner->id == $user->id);
		$this->assertTrue($found->assigned_by == $user->id);
		$this->assertTrue($found->assigned_to == $user->id);
		$this->assertTrue($found->minutes_before == $newtodo->minutes_before);

		//Test Tags
		$this->assertTrue(count($found->tags) == 2);
		
		// Delete
		$this->assertTrue( $found->delete() );

		unset($newtodo);
	}

	  public function testTodoValidation() {
     	$faker = \Faker\Factory::create();

     	$user = parent::createFakeUser();
	
		$newtodo = new \Models\Todo();
		
		$this->assertFalse( $newtodo->validate() );
		
		$this->assertTrue( $newtodo->errors()->first("owner_id") == "The owner id field is required." );
		$this->assertTrue( $newtodo->errors()->first("title") == "The title field is required." );
		$this->assertTrue( $newtodo->errors()->first("due_date") == "The due date field is required." );
		$this->assertTrue( $newtodo->errors()->first("assigned_by") == "The assigned by field is required." );
		$this->assertTrue( $newtodo->errors()->first("assigned_to") == "The assigned to field is required." );
		$this->assertTrue( $newtodo->errors()->first("minutes_before") == "The minutes before field is required." );

		$newtodo->household_id = $faker->uuid;
		$newtodo->owner_id   = $faker->uuid;
		$newtodo->title = 'dd';
		$newtodo->due_date = 'date';
		$newtodo->assigned_by = $faker->uuid;
		$newtodo->assigned_to = $faker->uuid;
		$newtodo->minutes_before = "se";

		$this->assertFalse( $newtodo->validate() );
		
		$this->assertTrue( $newtodo->errors()->first("owner_id") == "The selected owner id is invalid." );
		$this->assertTrue( $newtodo->errors()->first("title") == "The title must be at least 3 characters." );
		$this->assertTrue( $newtodo->errors()->first("due_date") == "The due date is not a valid date." );
		$this->assertTrue( $newtodo->errors()->first("assigned_by") == "The selected assigned by is invalid." );
		$this->assertTrue( $newtodo->errors()->first("assigned_to") == "The selected assigned to is invalid." );
		$this->assertTrue( $newtodo->errors()->first("minutes_before") == "The minutes before must be an integer." );

		$newtodo->setOwner( $user );
		$newtodo->title = $faker->text(15);
		$newtodo->due_date = $faker->date;
		$newtodo->setAssignedBy( $user );
		$newtodo->setAssignedTo( $user );
		$newtodo->minutes_before = 100;
			
		// echo($newtodo->errors()->first("household_id"));
		// echo($newtodo->errors()->first("owner_id"));
		// echo($newtodo->errors()->first("title"));
		// echo($newtodo->errors()->first("due_date"));
		// echo($newtodo->errors()->first("assigned_by"));
		// echo($newtodo->errors()->first("assigned_to"));
		//echo($newtodo->errors()->first("minutes_before"));

		$this->assertFalse( $newtodo->validate() );
		
		unset($newtodo);
	  }

	public function testInvalidTodoCannotSave() {

		$model = new \Models\RecipeReview();
		$model->title = "aa";

		//Try to save data
		$this->assertFalse($model->save());		
	}


}