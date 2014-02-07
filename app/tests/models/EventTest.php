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

		//get Event from database
		$found = \Models\Event::where('id', '=', $id)->firstOrFail();
		
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

		//Test Household
		$this->assertTrue($found->household->id == $newevent->household_id);

		//Test User	
		$this->assertTrue($found->owner->id == $newevent->owner_id);

		//Test Attendees
		$this->assertTrue(count($found->attendees) == 2);

		// echo "\nEvent Test: User Id: " . $user->id;
		// echo "\nEvent Test: User Household Id: " . $user->household->id . "\n";
		
		// Delete
		$this->assertTrue( $found->delete() );

	}

}