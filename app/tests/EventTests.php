<?php

class EventTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanCreateEventSaveRetrieveAndDelete()
	{

    	$faker = \Faker\Factory::create();
		
		// Get the owner
		$user = \Models\User::where('name', '=', 'Deon van der Vyver')->first();
		
		// Create Event
		$event = new \Models\Event();
		$event->title = ucwords($faker->bs);
		$event->description = $faker->paragraph($nbSentences = 3);
		$event->location = $faker->address;
		$event->event_date = $faker->date;
		$event->start_time = "17:00:00";
		$event->end_time = "18:00:00";
		$event->all_day = false;
		$event->notify = false;
		$event->minutes_before = 0;
		$event->type = "call";

		// set Owner
        $event->setOwner( $user );
		
		$event->save();

		$id = $event->id;

		// Get Event from database
		$found = \Models\Event::where('id', '=', $id)->with('owner','household')->firstOrFail();
		// print_r($found);
		// echo "\nFound Id: " . $found->id . "\n";

		$this->assertTrue($found->id == $id);

		// Test Event
		$this->assertTrue($found->id == $event->id);
		$this->assertTrue($found->title == $event->title);
		$this->assertTrue($found->description == $event->description);
		$this->assertTrue($found->location == $event->location);
		$this->assertTrue($found->date == $event->date);
		$this->assertTrue($found->start_time == $event->start_time);
		$this->assertTrue($found->end_time == $event->end_time);
		$this->assertTrue($found->all_day == $event->all_day);
		$this->assertTrue($found->notify == $event->notify);
		$this->assertTrue($found->minutes_before == $event->minutes_before);
		$this->assertTrue($found->type == $event->type);
		$this->assertTrue($found->owner->id == $user->id);
		$this->assertTrue($found->household->id == $user->household->id);

		// Delete
		$this->assertTrue($found->delete());
	}

}