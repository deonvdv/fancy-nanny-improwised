<?php

class MealAPITest extends TestCase {

	public function testMealsAPI()
	{
		$crawler = $this->client->request('GET', '/api/v1/meals');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testStoreGetUpdateAndDeleteCategory() {
		$faker = \Faker\Factory::create();

		$household = parent::createFakeHousehold();
		$week_number = 1;
		$day_of_week = 1;
		$slot = 'lunch';

		$response = $this->call('POST', '/api/v1/meal', array('household_id' => $household->id,
												"week_number" => $week_number,
												"day_of_week" => $day_of_week,
												"slot" => $slot) );
		$recordId = $response->getData()->data->id;

		// Test that record was added
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $recordId != '' );
		$this->assertTrue( $response->getData()->data->week_number == $week_number );
		$this->assertTrue( $response->getData()->data->day_of_week == $day_of_week );
		$this->assertTrue( $response->getData()->data->slot == $slot );
		$this->assertTrue( $response->getData()->data->household_id == $household->id );
		$this->assertTrue( $response->getData()->message == 'New Meal created sucessfully!' );

		// test that location header is set
		$this->assertTrue( stripos( $response->headers, "Location:" ) !== false );
		$this->assertTrue( stripos( $response->headers, "/meal/".$recordId ) !== false );
		
		// verify insert was sucessful
		$response = $this->call('GET', '/api/v1/meal/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->week_number == $week_number );
		$this->assertTrue( $response->getData()->data->day_of_week == $day_of_week );
		$this->assertTrue( $response->getData()->data->slot == $slot );
		$this->assertTrue( $response->getData()->data->household_id == $household->id );

		// edit meal
		$changedSlot = 'breakfast';
		$response = $this->call('PUT', '/api/v1/meal/'.$recordId, array('slot' => $changedSlot) );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->slot == $changedSlot );
		$this->assertTrue( $response->getData()->message == 'Meal updated sucessfully!' );


		// verify update was sucessful
		$response = $this->call('GET', '/api/v1/meal/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->slot == $changedSlot );

		// make invalid update
		$response = $this->call('PUT', '/api/v1/meal/'.$recordId, array('day_of_week' => 0) );	// name is too short
		$this->assertFalse( $response->getData()->success );
		$this->assertTrue( $response->getData()->message == 'Error updating Meal!' );


		// now delete the meal
		$response = $this->call('DELETE', '/api/v1/meal/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->message == 'Meal deleted successfully!' );


		// verify delete was sucessful
		$response = $this->call('GET', '/api/v1/meal/'.$recordId );
		$this->assertFalse( $response->getData()->success );
		$this->assertTrue( stripos( $response->getData()->message, 'Could not find Meal with id' ) !== false );
	
	}

}