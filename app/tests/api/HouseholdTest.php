<?php

class HouseholdAPITest extends TestCase {

	public function testHouseholdsAPI()
	{
		$crawler = $this->client->request('GET', '/api/v1/households');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testStoreGetUpdateAndDeleteHousehold() {
		$faker = \Faker\Factory::create();

		$contacts = ["Father", "Mother", "Sister", "Brother", "Aunt", "Uncle", "Grandfather", "Grandmother"];
		$emergency_contacts = json_encode( [ 
		        			$contacts[rand(0, 7)] => ["name" => $faker->name, "contact_number" => $faker->phoneNumber, "contact_email" => $faker->safeEmail], 
		        			$contacts[rand(0, 7)] => ["name" => $faker->name, "contact_number" => $faker->phoneNumber, "contact_email" => $faker->safeEmail], 
		        			$contacts[rand(0, 7)] => ["name" => $faker->name, "contact_number" => $faker->phoneNumber, "contact_email" => $faker->safeEmail], 
		        			$contacts[rand(0, 7)] => ["name" => $faker->name, "contact_number" => $faker->phoneNumber, "contact_email" => $faker->safeEmail], 
		        			] );
		$householdName = $faker->unique()->lastName . " Household";
		$critical_information = $faker->paragraph($nbSentences = 3);

		$response = $this->call('POST', '/api/v1/household', 
					array("name"      => $householdName, 
						"emergency_contacts" => $emergency_contacts, 
						"critical_information"	=> $critical_information ) );
		$recordId = $response->getData()->data->id;

		// Test that record was added
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $recordId != '' );
		$this->assertTrue( $response->getData()->data->name == $householdName );
		$this->assertTrue( $response->getData()->data->emergency_contacts == $emergency_contacts );
		$this->assertTrue( $response->getData()->data->critical_information == $critical_information );
		$this->assertTrue( $response->getData()->message == 'New Household created sucessfully!' );


		// test that location header is set
		$this->assertTrue( stripos( $response->headers, "Location:" ) !== false );
		$this->assertTrue( stripos( $response->headers, "/household/".$recordId ) !== false );
		

		// verify insert was sucessful
		$response = $this->call('GET', '/api/v1/household/'.$recordId );
		$this->assertTrue( $response->getData()->data->name == $householdName );
		$this->assertTrue( $response->getData()->data->emergency_contacts == $emergency_contacts );
		$this->assertTrue( $response->getData()->data->critical_information == $critical_information );
		
		// edit household
		$response = $this->call('PUT', '/api/v1/household/'.$recordId, array('name' => $householdName."_changed") );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->name == $householdName."_changed" );
		$this->assertTrue( $response->getData()->message == 'Household updated sucessfully!' );


		// verify update was sucessful
		$response = $this->call('GET', '/api/v1/household/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->name == $householdName."_changed" );

		// make invalid update
		$response = $this->call('PUT', '/api/v1/household/'.$recordId, array('name' => "x") );	// name is too short
		$this->assertFalse( $response->getData()->success );
		$this->assertTrue( $response->getData()->message == 'Error updating Household!' );

		//Get relevant documents
		$response = $this->call('GET', '/api/v1/household/'.$recordId.'/documents/' );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( stripos( $response->getData()->message, 'No records found in this collection.' ) !== false );
	
		// now delete the household
		$response = $this->call('DELETE', '/api/v1/household/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->message == 'Household deleted successfully!' );

		// verify delete was sucessful
		$response = $this->call('GET', '/api/v1/household/'.$recordId );
		$this->assertFalse( $response->getData()->success );
		$this->assertTrue( stripos( $response->getData()->message, 'Could not find Household with id' ) !== false );
				
	}
}