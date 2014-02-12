<?php

use \Models;

class UserModelTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanUserSaveRetrieveAndDelete()
	{
        // echo "\nUser Test...\n";
        
    	$faker = \Faker\Factory::create();
		
        // var_dump($tmp);
        $newuser = parent::createFakeUser();
        // print_r($newuser);

        $household = parent::createFakeHousehold();

        //associate household
        $household = parent::createFakeHousehold();
        $newuser->setHousehold( $household );
        // print_r( $newuser );
        // return;

		//Set Profile picture
		$profilepic = parent::createFakePicture();
        $newuser->addProfilePicture( $profilepic );
        // echo "Profile Pic Id: " . $profilepic->id . "\n";

        //Add Documents
        $doc = parent::createFakeDocument();
        $doc->setOwner( $newuser );
        $newuser->addDocument( $doc );
        // echo "Document Id: " . $doc->id . "\n";
        // print_r( $newuser );
        // print_r( $doc );
        // return;

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
        $event->setOwner( $newuser );

        $newuser->addEvent( $event );
        // echo "Event Id: " . $event->id . "\n";
        // print_r( $newuser );
        // print_r( $event );
        // return;


        // Add Messages
        $msg = parent::createFakeMessage( $newuser, null );
        // $msg->setSender( $newuser );
        // $msg->setReceiver( );
        // $msg->save();
        // $newuser->messages()->save($msg);
        $newuser->addMessageSent( $msg );
        // print_r( $newuser );
        // print_r( $msg );
        // return;

         //Add Notifications
        $notification = new \Models\Notification( array (
                        'message' => $faker->paragraph($nbSentences = 6), 
        				'to' => substr('from msg:' . $faker->word,0,36),
        				'reference' => substr('ref:' . $faker->word,0,50)) );
        $notification->setUser( $newuser );
        $newuser->addNotification( $notification );
        // print_r( $notification );
        // return;

        //Add Recipes
        $recipe = parent::createFakeRecipe();
        $newuser->addRecipe( $recipe );
        // print_r( $recipe );
        // return;

        //Add Tags
        $tag1 = parent::createFakeTag();
        $newuser->addTag( $tag1 );
        // print_r( $tag1 );
        // return;

        $tag2 = parent::createFakeTag();
        $newuser->addTag( $tag2 );
        // print_r( $tag2 );
        // return;

        //Add Todos
        $todo = new \Models\Todo( array (
                        'title' => $faker->name,
                        'description' => $faker->text,
                        'due_date' => $faker->date,
                        'is_complete' => $faker->boolean,
                        'notify' => $faker->name,    
                        'assigned_by' => $newuser->id,
                        'assigned_to' => $newuser->id,                   
                        'minutes_before' => $faker->randomDigitNotNull));
        $todo->setOwner( $newuser );
        //$todo->setAssignedBy( $newuser );
        //$todo->setAssignedTo( $newuser );
        // $newuser->todos()->save($todo);
        $newuser->addTodo( $todo );
        // print_r( $newuser );
        // print_r( $todo );
        // return;

        //Add Pictures
        for($x = 0;$x < 2;$x++) {
            // echo "Here...\n";
            $pic = parent::createFakePicture($newuser);
            $newuser->addPicture( $pic );
            //print_r($pic);
        }
        // return;

        //Add FavoriteRecipes
        $newuser->addFavoriteRecipe($recipe);

        // echo "\n\nUser Id: " . $newuser->id . "\n";

        $id = $newuser->id;
        
		// Get User from database
		$found = \Models\User::with( array (
                        'documents','profile_picture',
			            'events','household', 
                        'messages_sent',
                        'messages_received',
                        'notifications','recipes',
                        'tags',
                        'todos','pictures') )->where('id', '=', $id)->firstOrFail();
        // print_r($found);
		$this->assertTrue($found->id == $id);
        // echo "Found User Id: " . $found->id . "\n";

		//Test profile_picture
        // echo $found->profile_picture->id . "\n";
        // echo $profilepic->id . "\n";
        // echo "Found Profile Pic Id: " . $found->profile_picture->id . "\n";

		//Test documents
		$this->assertTrue(count($found->documents) == 1);

		//Test events
		$this->assertTrue(count($found->events) == 1);

		// Test Household
		$this->assertTrue($found->household->id == $household->id);
		$this->assertTrue($found->household->name == $household->name);

		//Test messages
		$this->assertTrue(count($found->messages_sent) == 1);

		//Test notifications
		$this->assertTrue(count($found->notifications) == 1);

        //Test recipes
        $this->assertTrue(count($found->recipes) == 1);

        //Test tags
        $this->assertTrue(count($found->tags) == 2);

        //Test todos
        $this->assertTrue(count($found->todos) == 1);

        //Test pictures
        //print_r('pictures:'.count($found->pictures));
        $this->assertTrue(count($found->pictures) == 3);

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

    public function testUserValidation() {
        $faker = \Faker\Factory::create();

        $newuser = new \Models\User();
        $newuser->name = "";
        $newuser->email = "";
        
        $this->assertFalse( $newuser->validate() );
        
        $this->assertTrue( $newuser->errors()->first("name") == "The name field is required." );
        $this->assertTrue( $newuser->errors()->first("email") == "The email field is required." );
        $this->assertTrue( $newuser->errors()->first("street") == "The street field is required." );
        $this->assertTrue( $newuser->errors()->first("city") == "The city field is required." );
        $this->assertTrue( $newuser->errors()->first("zip") == "The zip field is required." );
        $this->assertTrue( $newuser->errors()->first("country") == "The country field is required." );


        $newuser->name = $faker->sentence(200);
        $newuser->email = $faker->sentence(200);
        $newuser->street = $faker->sentence(200);
        $newuser->city = $faker->sentence(200);
        $newuser->zip = $faker->sentence(200);
        $newuser->country = $faker->sentence(200);
        
        $this->assertFalse( $newuser->validate() );
        
        $this->assertTrue( $newuser->errors()->first("name") == "The name must be between 4 and 100 characters." );
        $this->assertTrue( $newuser->errors()->first("email") == "The email format is invalid." );
        $this->assertTrue( $newuser->errors()->first("street") == "The street must be between 3 and 100 characters." );
        $this->assertTrue( $newuser->errors()->first("city") == "The city must be between 2 and 50 characters." );
        $this->assertTrue( $newuser->errors()->first("zip") == "The zip must be between 5 and 20 characters." );
        $this->assertTrue( $newuser->errors()->first("country") == "The country must be between 2 and 50 characters." );


        $newuser->name = $faker->text(15);
        $newuser->email = $faker->email;
        $newuser->street = $faker->text(80);
        $newuser->city = $faker->text(35);
        $newuser->zip = $faker->postcode;
        $newuser->country = $faker->text(30);
      
        if ( !$newuser->validate() ) {
            var_dump( $newuser->errors() );
            var_dump( $newuser );
        }
        $this->assertTrue( $newuser->validate() );
        // print_r( $newuser->errors() );
        
        unset($newuser);
    }

    public function testInvalidUserCannotSave() {

        $model = new \Models\User();
        $model->name = "aa";

        $this->assertFalse( $model->save() );
    }

}