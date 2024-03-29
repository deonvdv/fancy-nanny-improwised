<?php

use \Models;

class EventModelTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanCreateEventSaveAndRetrieve()
	{
		// echo "\nEvent Test...\n";
		
    	$faker = \Faker\Factory::create();

		$user = parent::createFakeUserWithFakeHousehold();
		// print_r( $user );

		$newevent = new \Models\Event();		
        $newevent->title = ucwords($faker->bs);
        $newevent->description = $faker->text;
        $newevent->location = $faker->address;
        $newevent->event_date = $faker->date;
        $newevent->start_time = $faker->time($format = 'H:i:s');
        $newevent->end_time = $faker->time($format = 'H:i:s');
        $newevent->all_day = $faker->boolean;
        $newevent->notify = $faker->boolean;
        $newevent->minutes_before = $faker->randomDigitNotNull;
        $newevent->type = 'travel';

        $newevent->setOwner( $user );
        
        //Add Attendees
       	// $attendees = \Models\User::where('id','!=',$user->id)->take(5)->get();
       	for($i = 0; $i < 2; $i++){
       		$attendee = parent::createFakeUser( $user->household );
       		// print_r($attendee);
       		$newevent->addAttendee($attendee);
       	}

		$id = $newevent->id;

		// Add Tags
		$tag1 = parent::createFakeTag( $user );
		$newevent->addTag( $tag1 );

		$tag2 = parent::createFakeTag( $user );
		$newevent->addTag( $tag2 );

		//get Event from database
		$found = \Models\Event::with('tags')->where('id', '=', $id)->firstOrFail();
		
		$this->assertTrue($found->id == $id);

		// Test Event
		$this->assertTrue($found->id == $newevent->id);		
		$this->assertTrue($found->title == $newevent->title);
		$this->assertTrue($found->description == $newevent->description);
		$this->assertTrue($found->location == $newevent->location);
		$this->assertTrue($found->event_date == $newevent->event_date);
		$this->assertTrue($found->event_start_time == $newevent->event_start_time);
		$this->assertTrue($found->event_end_time == $newevent->event_end_time);
		$this->assertTrue($found->all_day == $newevent->all_day);
		$this->assertTrue($found->notify == $newevent->notify);
		$this->assertTrue($found->minutes_before == $newevent->minutes_before);
		$this->assertTrue($found->type == $newevent->type);

		//Test User	
		$this->assertTrue($found->owner->id == $newevent->owner_id);

		//Test Attendees
		$this->assertTrue(count($found->attendees) == 2);

		//Test Tags
		$this->assertTrue(count($found->tags) == 2);

		// echo "\nEvent Test: User Id: " . $user->id;
		// echo "\nEvent Test: User Household Id: " . $user->household->id . "\n";
		
		// Delete
		$this->assertTrue( $found->delete() );

	}

	public function testEventValidation() {
    	$faker = \Faker\Factory::create();

		$user = parent::createFakeUserWithFakeHousehold();

		$event = new \Models\Event();
        $event->title = "xx";
        $event->location = "xx";
        $event->event_date = "xx";
        $event->start_time = "xx";
        $event->end_time = "xx";
        $event->notify = "xx";
        $event->type = "xx";

		// var_dump( $event->validate() );
		// var_dump( $event->errors() );
		$this->assertFalse( $event->validate() );
		// print_r( $event->errors()->first("name") );
		// print_r( $event->errors()->first("file_name") );
		// print_r( $event->errors()->first("household_id") );
		// print_r( $event->errors()->first("owner_id") );

		$this->assertTrue( $event->errors()->first("owner_id") == "The owner id field is required." );
		$this->assertTrue( $event->errors()->first("title") == "The title must be at least 3 characters." );
		$this->assertTrue( $event->errors()->first("event_date") == "The event date is not a valid date." );
		$this->assertTrue( $event->errors()->first("start_time") == "The start time does not match the format H:i:s." );
		$this->assertTrue( $event->errors()->first("end_time") == "The end time does not match the format H:i:s." );
		$this->assertTrue( $event->errors()->first("minutes_before") == "The minutes before field is required." );

        $event->title = ucwords($faker->bs);
        $event->description = $faker->text;
        $event->location = $faker->address;
        $event->event_date = $faker->date;
        $event->start_time = $faker->time($format = 'H:i:s');
        $event->end_time = $faker->time($format = 'H:i:s');
        $event->notify = $faker->boolean;
        $event->all_day = $faker->boolean;
        $event->type = 'travel';

		// set Owner
        $event->setOwner( $user );
        $event->minutes_before = 200;

        $this->assertFalse( $event->validate() );
   		// var_dump( $event->validate() );
		// var_dump( $event->errors() );
        $this->assertTrue( $event->errors()->first("minutes_before") == "The minutes before must be between 1 and 59." );

		$event->minutes_before = 20;
		
		$this->assertTrue( $event->validate() );
		unset($event);
	}

	public function testInvalidEventCannotSave() {

		$model = new \Models\Event();
		$model->title = "aa";

		$this->assertFalse( $model->save() );
	}


}