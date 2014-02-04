<?php

class PictureTest extends TestCase {

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

    	$faker = \Faker\Factory::create();

		// $this->migrate();
		// $this->seed();

		// Get Author
		$user = \Models\User::where('name', '=', 'Deon van der Vyver')->first();

		$picture_name = $faker->bs;
		$filename = $faker->name . "." . $faker->fileExtension;
		$cdn = $faker->url.$filename;

    	$tmp = array(
            'name' => $picture_name,
            'file_name' => $filename,
            'cdn_url' => $cdn,
        );
        // print_r($tmp);
		$pic = new \Models\Picture( $tmp );
		// print_r($pic);
			
		// Add the Picture Owner
		$pic->owner()->associate($user); 	// I fixed the association (belongsTo)

		// print_r($pic);
		$user->pictures()->save($pic);
		
		// print_r($pic);

		$this->assertTrue($pic->id !== '');
		$this->assertTrue($pic->owner_id == $user->id);
		$this->assertTrue($pic->name == $picture_name);
		$this->assertTrue($pic->file_name == $filename);
		$this->assertTrue($pic->cdn_url == $cdn);

		$id = $pic->id;

		$found = \Models\Picture::with( array('owner') )->where('id', '=', $id)->firstOrFail();
		// print_r($found);

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