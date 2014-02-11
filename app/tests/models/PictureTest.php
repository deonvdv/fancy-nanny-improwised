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

		// var_dump( $pic );

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

	public function testPictureValidation() {
    	$faker = \Faker\Factory::create();

		$user = parent::createFakeUserWithFakeHousehold();

		$picture = new \Models\Picture();
        $picture->name = "aa";
        $picture->file_name = "aa";

		// var_dump( $picture->validate() );
		// var_dump( $picture->errors() );
		$this->assertFalse( $picture->validate() );

		$this->assertTrue( $picture->errors()->first("name") == "The name must be at least 3 characters." );
		$this->assertTrue( $picture->errors()->first("owner_id") == "The owner id field is required." );
		$this->assertTrue( $picture->errors()->first("file_name") == "The file name must be at least 3 characters." );
		$this->assertTrue( $picture->errors()->first("imageable_id") == "The imageable id field is required." );
		$this->assertTrue( $picture->errors()->first("imageable_type") == "The imageable type field is required." );

		$picture->name = $faker->text(100);
		$picture->file_name = $faker->text(100);
		$picture->cdn_url = $faker->url;
		// set Owner
        $picture->setOwner( $user );

		$this->assertTrue( $picture->validate() );
		unset($picture);
	}

	public function testInvalidPictureCannotSave() {

		$model = new \Models\Picture();
		$model->name = "aa";

		$this->assertFalse( $model->validate() );
	}

}