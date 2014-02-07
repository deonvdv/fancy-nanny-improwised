<?php

use \Models;

class PictureModelTest extends TestCase {

	// public function setUp() {
 //        // parent::setUp();

 //        // Artisan::call('migrate');
 //        // Artisan::call('db:seed');
 //        // Mail::pretend(true);
 //    }

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanCreatePictureSaveRetrieveAndDelete()
	{
		// echo "\nPicture Test...\n";
		
    	$faker = \Faker\Factory::create();

		// $this->migrate();
		// $this->seed();

		// Get Author
		$user = parent::createFakeUserWithFakeHousehold();

		$picture_name = $faker->bs;
		$filename = $faker->name . "." . $faker->fileExtension;
		$cdn = $faker->url.$filename;

		$pic = new \Models\Picture( );

		$pic->name = $picture_name;
		$pic->file_name = $filename;
		$pic->cdn_url = $cdn;
		// $pic->imageable_id = $faker->uuid;
		// $pic->imageable_type = $faker->name;

		// Add the Picture Owner
		$pic->setOwner($user);

		// $user->pictures()->save($pic);
		
		$this->assertTrue($pic->id !== '');
		$this->assertTrue($pic->owner_id == $user->id);
		$this->assertTrue($pic->name == $pic->name);
		$this->assertTrue($pic->file_name == $pic->file_name);
		$this->assertTrue($pic->cdn_url == $pic->cdn_url);

		$id = $pic->id;

		$found = \Models\Picture::where('id', '=', $id)->firstOrFail();
		// print_r($found);
		// echo "\nFound Id: " . $found->id . "\n";

		$this->assertTrue($found->id == $id);

		// Test Owner
		$this->assertTrue($found->owner_id == $user->id);
		$this->assertTrue($found->owner->id == $user->id);
		$this->assertTrue($found->owner->name == $user->name);
		$this->assertTrue($found->owner->email == $user->email);
		$this->assertTrue($found->name == $picture_name);
		$this->assertTrue($found->file_name == $filename);
		$this->assertTrue($found->cdn_url == $cdn);

		// Delete
		$this->assertTrue($found->delete());

	}

}