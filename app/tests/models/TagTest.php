<?php

use \Models;

class TagModelTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanCreateTagSaveRetrieveAndDelete()
	{
		// echo "\nTag Test...\n";
		
    	$faker = \Faker\Factory::create();

		// Get the owner
		$user = parent::createFakeUserWithFakeHousehold();

		// Create new Tag
		$tag = new \Models\Tag();
        $tag->name = ucwords($faker->bs);
        $tag->color = $faker->hexcolor;
        $tag->setOwner( $user );

		$id = $tag->id;

		// var_dump( $tag->validate() );
		 var_dump( $tag->errors() );
		var_dump($id);
		//get Tag from database
		$found = \Models\Tag::where('id', '=', $id)->firstOrFail();
		//print_r($found);
		// echo "\nFound Id: " . $found->id . "\n";
		
		$this->assertTrue($found->id == $id);

		// Test Tag
		$this->assertTrue($found->id == $tag->id);
		$this->assertTrue($found->name == $tag->name);
		$this->assertTrue($found->color == $tag->color);
		$this->assertTrue($found->owner->id == $user->id);
		
		// Delete
		$this->assertTrue( $found->delete() );
	}

	public function testTagValidation() {
    	$faker = \Faker\Factory::create();

		$user = parent::createFakeUserWithFakeHousehold();

		$tag = new \Models\Tag();
        $tag->name = "aa";

		// var_dump( $tag->validate() );
		// var_dump( $tag->errors() );
		$this->assertFalse( $tag->validate() );

		$this->assertTrue( $tag->errors()->first("name") == "The name must be at least 3 characters." );
		$this->assertTrue( $tag->errors()->first("color") == "The color field is required." );
		$this->assertTrue( $tag->errors()->first("owner_id") == "The owner id field is required." );

        $tag->name = ucwords($faker->bs);
        $tag->color = $faker->hexcolor;

		// var_dump( $tag->validate() );
		// var_dump( $tag->errors() );

		// set Owner
        $tag->setOwner( $user );

		// var_dump( $tag->validate() );
		// var_dump( $tag->errors() );
		$this->assertTrue( $tag->validate() );

	}

	public function testInvalidTagCannotSave() {

		$model = new \Models\Tag();
		$model->name = "aa";

		$this->assertFalse( $model->validate() );
	}

}