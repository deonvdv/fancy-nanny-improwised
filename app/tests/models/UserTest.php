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
                        'minutes_before' => $faker->randomDigitNotNull));
        $todo->setAssignedBy( $newuser );
        $todo->setAssignedTo( $newuser );
        // $newuser->todos()->save($todo);
        $newuser->addTodo( $todo );
        // print_r( $newuser );
        // print_r( $todo );
        // return;

        //Add Pictures
        for($x = 0;$x < 2;$x++) {
            // echo "Here...\n";
            $pic = parent::createFakePicture();
            $newuser->addPicture( $pic );
            // print_r($pic);
        }
        // return;

        //Add FavoriteRecipes
        $newuser->addFavoriteRecipe($recipe);

        // echo "\n\nUser Id: " . $newuser->id . "\n";

        $id = $newuser->id;
        
		// Get User from database
		$found = \Models\User::with( array (
                        'profile_picture','documents',
			            'events','household', 
                        'messages_sent',
                        'messages_received',
                        'notifications','recipes',
                        'tags',
                        'todos','pictures') )->where('id', '=', $id)->firstOrFail();
        // print_r($found);
		$this->assertTrue($found->id == $id);
        // echo "Found User Id: " . $found->id . "\n";

		// //Test profile_picture
  //       echo $found->profile_picture->id . "\n";
  //       echo $profilepic->id . "\n";
  //       echo "Found Profile Pic Id: " . $found->profile_picture->id . "\n";

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
        $this->assertTrue(count($found->pictures) == 2);

        //Test favoriterecipe
        $this->assertTrue(count($found->favoriterecipes) == 1);

		// Test User
		$this->assertTrue($found->id == $newuser->id);
		$this->assertTrue($found->name == $newuser->name);
		$this->assertTrue($found->street == $newuser->street);
		$this->assertTrue($found->city == $newuser->city);

		// Delete
		// $this->assertTrue($found->delete());
		
	}

}