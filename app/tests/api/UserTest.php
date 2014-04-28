<?php

class UserAPITest extends TestCase {

    public function testUsersAPI()
    {
        $crawler = $this->client->request('GET', '/api/v1/users');
        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testStoreGetUpdateAndDeleteUser() {
		$faker = \Faker\Factory::create();

		$profilepic = parent::createFakePicture();

		$household = parent::createFakeHousehold();

		$name = $faker->name.' API Test user';
        $email = $faker->email;
        $password = Hash::make($faker->word . strtoupper($faker->randomLetter) . $faker->randomDigitNotNull . $faker->word);
        $street   = $faker->streetAddress;
        $city     = $faker->city;
        $state    = $faker->state;
        $zip      = $faker->postcode;
        $country   = substr($faker->country,0,50);
       	$role         = 'staff';
        $app_settings  = json_encode( array("preferred_notification" => rand(0, 1) ? 'email' : 'text' ) );
        

		$response = $this->call('POST', '/api/v1/user', 
					array('name' => $name,
					'email' => $email,
        			'password' => $password,
        			'street'   => $street,
			        'city'    => $city,
			        'state'   => $state,
			        'zip'     => $zip,
			        'country'  => $country,
			        'role'         => $role,
			        'app_settings'  => $app_settings,
			        'profile_picture_id' => $profilepic->id,
			        'household_id' => $household->id) );
		$recordId = $response->getData()->data->id;

		// Test that record was added
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $recordId != '' );
		$this->assertTrue( $response->getData()->data->name == $name );
		$this->assertTrue( $response->getData()->data->email == $email );
		$this->assertTrue( $response->getData()->data->street == $street );
		$this->assertTrue( $response->getData()->data->city == $city );
		$this->assertTrue( $response->getData()->data->state == $state );
		$this->assertTrue( $response->getData()->data->zip == $zip );
		$this->assertTrue( $response->getData()->data->country == $country );
				
		$this->assertTrue( $response->getData()->data->role == $role );
		$this->assertTrue( $response->getData()->data->app_settings == $app_settings );
		$this->assertTrue( $response->getData()->data->profile_picture_id == $profilepic->id );
		$this->assertTrue( $response->getData()->data->household_id == $household->id );
		$this->assertTrue( $response->getData()->message == 'New User created sucessfully!' );


		// test that location header is set
		$this->assertTrue( stripos( $response->headers, "Location:" ) !== false );
		$this->assertTrue( stripos( $response->headers, "/user/".$recordId ) !== false );
		

		// verify insert was sucessful
		$response = $this->call('GET', '/api/v1/user/'.$recordId );
		$this->assertTrue( $response->getData()->data->name == $name );
		$this->assertTrue( $response->getData()->data->email == $email );
		$this->assertTrue( $response->getData()->data->street == $street );
		$this->assertTrue( $response->getData()->data->city == $city );
		$this->assertTrue( $response->getData()->data->state == $state );
		$this->assertTrue( $response->getData()->data->zip == $zip );
		$this->assertTrue( $response->getData()->data->country == $country );
		$this->assertTrue( $response->getData()->data->role == $role );
		$this->assertTrue( $response->getData()->data->app_settings == $app_settings );
		$this->assertTrue( $response->getData()->data->profile_picture_id == $profilepic->id );
		$this->assertTrue( $response->getData()->data->household_id == $household->id );
		
		// edit user
		$response = $this->call('PUT', '/api/v1/user/'.$recordId, array('name' => $name."_changed") );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->name == $name."_changed" );
		$this->assertTrue( $response->getData()->message == 'User updated sucessfully!' );


		// verify update was sucessful
		$response = $this->call('GET', '/api/v1/user/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->name == $name."_changed" );

		// make invalid update
		$response = $this->call('PUT', '/api/v1/user/'.$recordId, array('name' => "x") );	// name is too short
		$this->assertFalse( $response->getData()->success );
		$this->assertTrue( $response->getData()->message == 'Error updating User!' );

		//Get relevant tags
		$response = $this->call('GET', '/api/v1/user/'.$recordId.'/tags/' );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( stripos( $response->getData()->message, 'No records found in this collection.' ) !== false );
		
		//Get relevant pictures
		$response = $this->call('GET', '/api/v1/user/'.$recordId.'/picture/' );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( stripos( $response->getData()->message, 'No records found in this collection.' ) !== false );
		
		//Get relevant recipes
		$response = $this->call('GET', '/api/v1/user/'.$recordId.'/recipes/' );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( stripos( $response->getData()->message, 'No records found in this collection.' ) !== false );
		
		//Get relevant favorite_recipes
		$response = $this->call('GET', '/api/v1/user/'.$recordId.'/favorite_recipes/' );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( stripos( $response->getData()->message, 'No records found in this collection.' ) !== false );
		
		//Get relevant upcoming_events
		$response = $this->call('GET', '/api/v1/user/'.$recordId.'/upcoming_events/' );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( stripos( $response->getData()->message, 'No records found in this collection.' ) !== false );
		
		// now delete the user
		$response = $this->call('DELETE', '/api/v1/user/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->message == 'User deleted successfully!' );

		// verify delete was sucessful
		$response = $this->call('GET', '/api/v1/user/'.$recordId );
		$this->assertFalse( $response->getData()->success );
		$this->assertTrue( stripos( $response->getData()->message, 'Could not find User with id' ) !== false );
		
	}
}