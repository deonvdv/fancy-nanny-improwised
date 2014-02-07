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

		//get Tag from database
		$found = \Models\Tag::where('id', '=', $id)->firstOrFail();
		// print_r($found);
		// echo "\nFound Id: " . $found->id . "\n";
		
		$this->assertTrue($found->id == $id);

		// Test Tag
		$this->assertTrue($found->id == $tag->id);
		$this->assertTrue($found->name == $tag->name);
		$this->assertTrue($found->color == $tag->color);
		$this->assertTrue($found->owner->id == $user->id);
		$this->assertTrue($found->household->id == $user->household->id);

		// Delete
		$this->assertTrue( $found->delete() );
	}

}