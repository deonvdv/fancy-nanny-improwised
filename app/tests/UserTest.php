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
       
		//Set Profile picture
		$profilepic = new \Models\Picture( 
                array('name' => 'profile_pic_' . $faker->word, 
                    'imageable_id'=>$newuser->id,
                	'imageable_type' =>'User',
                    'cdn_url' => $faker->word, 
                    'file_name' => $faker->word.".".$faker->fileExtension) );
        $newuser->profile_picture()->save($profilepic);

        //Add Documents
        $doc = new \Models\Document( array('name' => 'doc_name' . $faker->word, 
        				'private' => $faker->boolean,
        			    'cdn_url' => $faker->word, 
        			    'household_id' => $household->id,
        			    'file_name' => $faker->word.".".$faker->fileExtension) );
        $newuser->documents()->save($doc);

        //Add Events
        $event = new \Models\Event();
        $event->title = ucwords($faker->bs);
        $event->description = $faker->text;
        $event->location = $faker->address;
        $event->event_date = $faker->date;
        $event->start_time = $faker->time($format = 'H:i:s');
        $event->end_time = $faker->time($format = 'H:i:s');
        $event->all_day = $faker->boolean;
        $event->notify = $faker->boolean;
        $event->minutes_before = $faker->randomDigitNotNull;
        $event->type = 'travel';
        $event->household_id = $household->id;
        $newuser->events()->save($event);

        //associate household
		$newuser->household()->associate($household);

        //Add Messages
        // $msg = new \Models\Message( array (
        //                 'message' => 'message_test' . $faker->word,
        //                 'sender_id' => $newuser->id,
        //                 'receiver_id' => $faker->uuid,     				
        // 			    'household_id' => $household->id) );
        // $msg->save();
        // $newuser->messages()->save($msg);

         //Add Notifications
        $notification = new \Models\Notification( array (
                        'message' => 'message_test' . $faker->word, 
        				'to' => substr('from msg:' . $faker->word,0,36),
        				'reference' => substr('ref:' . $faker->word,0,50),
        			    'household_id' => $household->id) );
        $newuser->notifications()->save($notification);

        $id = $newuser->id;

        //Add Recipes
        $recipe = new \Models\Recipe();
        $recipe->name = $faker->name;
        $recipe->description = $faker->text;
        $recipe->instructions = $faker->address;
        $recipe->number_of_portions = $faker->randomDigit;
        $recipe->preparation_time = $faker->time;
        $recipe->cooking_time = $faker->time;
        $newuser->recipes()->save($recipe);

        //Add Tags
        $tag1 = new \Models\Tag( array ('name' => 'tag 3',            
                                        'household_id' => $household->id, 
                                        'tagable_id'=> $faker->uuid,
                                        'tagable_type'=>$faker->name,                                     
                                        'color' => substr($faker->colorName,0,7)));
        $tag1->owner()->associate($newuser);        
        $tag2 = new \Models\Tag( array ('name' => 'tag 4',
                                        'household_id' => $household->id,  
                                        'tagable_id'=> $faker->uuid,
                                        'tagable_type'=>$faker->name,                                       
                                        'color' => substr($faker->colorName,0,7) ) );
        $tag2->owner()->associate($newuser);

        //Add Todos
        $todo = new \Models\Todo( array (
                        'household_id' => $household->id,                        
                        'title' => $faker->name,
                        'description' => $faker->text,
                        'due_date' => $faker->date,
                        'assigned_by' => $faker->uuid,
                        'assigned_to' => $faker->uuid,
                        'is_complete' => $faker->boolean,
                        'notify' => $faker->name,
                        'minutes_before' => $faker->randomDigitNotNull));
        $newuser->todos()->save($todo);

        //Add Pictures

       for($x = 0;$x < 2;$x++) {
            // echo "Here...\n";

            $tmp = array(
                'name' => $faker->bs,
                'file_name' => $faker->name . "." . $faker->fileExtension,
                'cdn_url' => $faker->url,
                'owner_id' =>$faker->uuid
            );

            $pic = new \Models\Picture( $tmp );
            // print_r($pic);
            
            // Add the Picture Owner
            $newuser->pictures()->save($pic);
        }

        //Add FavoriteRecipes
        $newuser->addFavoriteRecipe($recipe);

        
		// Get User from database
		$found = \Models\User::with( array (
                        'profile_picture','documents',
			            'events','household', 
                        //'messages',
                        'notifications','recipes',
                        //'tags',
                        'todos','pictures') )->where('id', '=', $id)->firstOrFail();
		$this->assertTrue($found->id == $id);

		//Test profile_picture
		$this->assertTrue($found->profile_picture->id == $profilepic->id);
		$this->assertTrue($found->profile_picture->name == $profilepic->name);
		$this->assertTrue($found->profile_picture->cdn_url == $profilepic->cdn_url);

		//Test documents
		$this->assertTrue(count($found->documents) == 1);

		//Test events
		$this->assertTrue(count($found->events) == 1);

		// Test Household
		$this->assertTrue($found->household->id == $household->id);
		$this->assertTrue($found->household->name == $household->name);

		//Test messages
		//$this->assertTrue(count($found->messages) == 1);

		//Test notifications
		$this->assertTrue(count($found->notifications) == 1);

        //Test recipes
        $this->assertTrue(count($found->recipes) == 1);

        //Test tags
        //$this->assertTrue(count($found->tags) == 2);

        //Test todos
        $this->assertTrue(count($found->todos) == 1);

        //Test pictures
        $this->assertTrue(count($found->pictures) == 2);

        //Test favoriterecipe
        $this->assertTrue(count($found->favoriterecipes) == 1);

		// Test User
		$this->assertTrue($found->id == $newuser->id);
		$this->assertTrue($found->name == $newuser->name);
		$this->assertTrue($found->street == $newuser->street);
		$this->assertTrue($found->city == $newuser->city);

		// Delete
		$this->assertTrue($found->delete());
		
	}

    public function testUsersAPI()
    {
        $crawler = $this->client->request('GET', '/api/v1/users');
        $this->assertTrue($this->client->getResponse()->isOk());
    }
}