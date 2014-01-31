<?php

class UserTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanUserSaveAndRetrieve()
	{

    	$faker = \Faker\Factory::create();
		
		// Get household
		$household = \Models\Household::where('name','like','%household')->first();
		$roles = ['parent','guardian','child','staff'];
		
		$newuser = new \Models\User();
		$newuser->name = $faker->name;
        $newuser->email = $faker->email;
        $newuser->password = Hash::make($faker->word . strtoupper($faker->randomLetter) . $faker->randomDigitNotNull . $faker->word);
        $newuser->street = $faker->streetAddress;
        $newuser->city = $faker->city;
        $newuser->state = $faker->state;
        $newuser->zip = $faker->postcode;
        $newuser->country = substr($faker->country,0,50);
        $newuser->home_number = $faker->optional($weight = 0.5)->phoneNumber;
        $newuser->work_number = $faker->optional($weight = 0.5)->phoneNumber;
        $newuser->role = $roles[rand(0, 3)];                
        $newuser->app_settings = json_encode( array("preferred_notification" => rand(0, 1) ? 'email' : 'text' ) );

        $newuser->save();
		
		//associate household
		$newuser->household()->associate($household);
        
		//Set Profile picture
		$pic = new \Models\Picture( 
                array('name' => 'profile_pic_' . $faker->word, 
                      'cdn_url' => $faker->word, 'file_name' => $faker->word.".".$faker->fileExtension) );
        $newuser->profile_picture()->save($pic);

        $id = $newuser->id;
        
		// Get User from database
		$found = \Models\User::with( array('household') )->where('id', '=', $id)->firstOrFail();
		
		$this->assertTrue($found->id == $id);

		// Test Household
		$this->assertTrue($found->household->id == $household->id);
		$this->assertTrue($found->household->name == $household->name);

		// Test User
		$this->assertTrue($found->id == $newuser->id);
		$this->assertTrue($found->name == $newuser->name);
		$this->assertTrue($found->street == $newuser->street);
		$this->assertTrue($found->city == $unitofmeasure->city);
	}

}