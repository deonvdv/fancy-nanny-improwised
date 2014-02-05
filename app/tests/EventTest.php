<?php

class EventTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanCreateEventSaveAndRetrieve()
	{

    	$faker = \Faker\Factory::create();

    	// Get household
		$household = \Models\Household::where('name','like','%household')->first();
		
		// Get User
		$user = \Models\User::where('name', '=', 'Deon van der Vyver')->first();

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

        //Set Household
        $newevent->household()->associate($household);
                
        //Set User
        $newevent->owner()->associate($user);
        $newevent->save();
        
		$id = $newevent->id;

		//get Event from database
		$found = \Models\Event::with( array ('household','owner') )
						->where('id', '=', $id)->firstOrFail();
		
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
		$this->assertTrue($found->name == $newevent->name);
		$this->assertTrue($found->name == $newevent->name);
		$this->assertTrue($found->name == $newevent->name);

		//Test Household
		$this->assertTrue($found->household->id == $newevent->household_id);
		$this->assertTrue($found->household->name == $household->name);	

		//Test User	
		$this->assertTrue($found->owner->id == $newevent->owner_id);
		$this->assertTrue($found->owner->name == $user->name);	
	}

}