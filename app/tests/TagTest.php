<?php

class TagTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanCreateTagSaveRetrieveAndDelete()
	{

    	$faker = \Faker\Factory::create();

		
		// Get the owner
		$user = \Models\User::where('name', '=', 'Deon van der Vyver')->first();

		// Get household
		$household = \Models\Household::where('name','like','%household')->first();

		// Create new Tag
		$tag = new \Models\Tag();
        $tag->name = ucwords($faker->bs);
        $tag->color = substr($faker->colorName,0,7);
        $tag->tagable_id = $faker->uuid;
        $tag->tagable_type = $faker->name;

        //associate household to user
		$user->household()->associate($household);
        
		// set Owner
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