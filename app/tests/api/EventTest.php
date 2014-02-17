<?php

class EventAPITest extends TestCase {

	public function testEventsAPI()
	{
		$crawler = $this->client->request('GET', '/api/v1/events');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testStoreGetUpdateAndDeleteDocument() {
		$faker = \Faker\Factory::create();

		$user = parent::createFakeUser();
		$title = ucwords($faker->bs);
		$description = $faker->text;
		$location = $faker->address;
		$event_date = $faker->date;
		$start_time = $faker->time($format = 'H:i:s');
		$end_time = $faker->time($format = 'H:i:s');
		$all_day = false;
		$notify = true;
		$minutes_before = $faker->randomDigitNotNull;
		$type = 'travel';

		$response = $this->call('POST', '/api/v1/event', 
					array('owner_id' => $user->id,
						"title"      => $title, 
						"description" => $description, 
						"location"	=> $location,  
						"event_date" => $event_date, 
						"start_time"	=> $start_time, 
						"end_time"	=> $end_time, 
						"minutes_before"	=> $minutes_before, 
						"type" => $type,
						"notify"	=> true, 
						"all_day"   => false ) );
		$recordId = $response->getData()->data->id;

		// Test that record was added
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $recordId != '' );
		$this->assertTrue( $response->getData()->data->title == $title );
		$this->assertTrue( $response->getData()->data->description == $description );
		$this->assertTrue( $response->getData()->data->location == $location );
		$this->assertTrue( $response->getData()->data->event_date == $event_date );
		$this->assertTrue( $response->getData()->data->start_time == $start_time );
		$this->assertTrue( $response->getData()->data->end_time == $end_time );
		$this->assertTrue( $response->getData()->data->minutes_before == $minutes_before );
		$this->assertTrue( $response->getData()->data->type == $type );
		$this->assertTrue( $response->getData()->data->notify == true );
		$this->assertTrue( $response->getData()->data->all_day == false );
		$this->assertTrue( $response->getData()->data->owner_id == $user->id );
		$this->assertTrue( $response->getData()->message == 'New Event created sucessfully!' );


		// test that location header is set
		$this->assertTrue( stripos( $response->headers, "Location:" ) !== false );
		$this->assertTrue( stripos( $response->headers, "/event/".$recordId ) !== false );
		

		// verify insert was sucessful
		$response = $this->call('GET', '/api/v1/event/'.$recordId );
		$this->assertTrue( $response->getData()->data->title == $title );
		$this->assertTrue( $response->getData()->data->description == $description );
		$this->assertTrue( $response->getData()->data->location == $location );
		$this->assertTrue( $response->getData()->data->event_date == $event_date );
		$this->assertTrue( $response->getData()->data->start_time == $start_time );
		$this->assertTrue( $response->getData()->data->end_time == $end_time );
		$this->assertTrue( $response->getData()->data->minutes_before == $minutes_before );
		$this->assertTrue( $response->getData()->data->notify == true );
		$this->assertTrue( $response->getData()->data->all_day == false );
		$this->assertTrue( $response->getData()->data->owner_id == $user->id );

		// edit event
		$response = $this->call('PUT', '/api/v1/event/'.$recordId, array('title' => $title."_changed") );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->title == $title."_changed" );
		$this->assertTrue( $response->getData()->message == 'Event updated sucessfully!' );


		// verify update was sucessful
		$response = $this->call('GET', '/api/v1/event/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->title == $title."_changed" );


		// make invalid update
		$response = $this->call('PUT', '/api/v1/event/'.$recordId, array('title' => "x") );	// name is too short
		$this->assertFalse( $response->getData()->success );
		$this->assertTrue( $response->getData()->message == 'Error updating Event!' );


		// now delete the category
		$response = $this->call('DELETE', '/api/v1/event/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->message == 'Event deleted successfully!' );


		// verify delete was sucessful
		$response = $this->call('GET', '/api/v1/event/'.$recordId );
		$this->assertFalse( $response->getData()->success );
		$this->assertTrue( stripos( $response->getData()->message, 'Could not find Event with id' ) !== false );
		
	}
}