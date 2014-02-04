<?php

class UserTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanUserSaveRetrieveAndDelete()
	{

    	$faker = \Faker\Factory::create();
		
		// Get household
		$household = \Models\Household::where('name','like','%household')->first();
		$roles = ['parent','guardian','child','staff'];
		
		 $tmp = [
            'name'               => "Shailesh ". $faker->word,
            'household_id'       => $household->id,
            'email'              => $faker->email,
            'password'           => Hash::make("xxx"),
            'street'             => "My Street",
            'city'               => "Cadiz",
            'state'              => "Cadiz",
            'zip'                => "11011",
            'country'            => "Spain",
            'home_number'        => "",
            'work_number'        => "",
            'role'               => "admin",
            'app_settings'       => json_encode( array("preferred_notification" => 'email' ) ),
        ];

        $newuser = new \Models\User( $tmp );
        $newuser->save();
       
		//associate household
		$newuser->household()->associate($household);
        
		//Set Profile picture
		$pic = new \Models\Picture( 
                array('name' => 'profile_pic_' . $faker->word, 'imageable_id'=>$newuser->id,
                	'imageable_type' =>'User',
                      'cdn_url' => $faker->word, 'file_name' => $faker->word.".".$faker->fileExtension) );
        $newuser->profile_picture()->save($pic);

        //Add Documents
        $doc = new \Models\Document( array('name' => 'doc_name' . $faker->word, 
        				'private' => $faker->boolean,
        			    'cdn_url' => $faker->word, 
        			    'household_id' => $household->id,
        			    'file_name' => $faker->word.".".$faker->fileExtension) );
        $newuser->documents()->save($doc);

        //Add Messages
        $msg = new \Models\Message( array('message' => 'message_test' . $faker->word, 
        				'date' => $faker->date,
        			    'household_id' => $household->id) );
        $newuser->messages()->save($msg);

         //Add Notifications
        $notification = new \Models\Notification( array('message' => 'message_test' . $faker->word, 
        				'to' => substr('from msg:' . $faker->word,0,36),
        				'reference' => substr('ref:' . $faker->word,0,50),
        			    'household_id' => $household->id) );
        $newuser->notifications()->save($notification);

        $id = $newuser->id;
        
		// Get User from database
		$found = \Models\User::with( array('household','profile_picture',
			'documents','messages','notifications') )->where('id', '=', $id)->firstOrFail();
		$this->assertTrue($found->id == $id);

		// Test Household
		$this->assertTrue($found->household->id == $household->id);
		$this->assertTrue($found->household->name == $household->name);

		//Test profile_picture
		$this->assertTrue($found->profile_picture->id == $pic->id);
		$this->assertTrue($found->profile_picture->name == $pic->name);
		$this->assertTrue($found->profile_picture->cdn_url == $pic->cdn_url);

		//Test documents
		$this->assertTrue(count($found->documents) == 1);

		//Test messages
		$this->assertTrue(count($found->messages) == 1);

		//Test notifications
		$this->assertTrue(count($found->notifications) == 1);

		// Test User
		$this->assertTrue($found->id == $newuser->id);
		$this->assertTrue($found->name == $newuser->name);
		$this->assertTrue($found->street == $newuser->street);
		$this->assertTrue($found->city == $newuser->city);

		// Delete
		$this->assertTrue($found->delete());
		
	}

}