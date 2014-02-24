<?php

class NotificationAPITest extends TestCase {

	public function testNotificationsAPI()
	{
		$crawler = $this->client->request('GET', '/api/v1/notifications');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testStoreGetUpdateAndDeleteNotification() {
		$faker = \Faker\Factory::create();

		$user = parent::createFakeUser();

		$to = $faker->email;
		$message = $faker->name;
		$reference = $faker->uuid();
		
		$response = $this->call('POST', '/api/v1/notification', 
					array('user_id' => $user->id,
						"to"      => $to, 
						"message" => $message, 
						"reference"	=> $reference ) );
		$recordId = $response->getData()->data->id;

		// Test that record was added
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $recordId != '' );
		$this->assertTrue( $response->getData()->data->to == $to );
		$this->assertTrue( $response->getData()->data->message == $message );
		$this->assertTrue( $response->getData()->data->reference == $reference );
		$this->assertTrue( $response->getData()->data->user_id == $user->id );
		$this->assertTrue( $response->getData()->message == 'New Notification created sucessfully!' );


		// test that location header is set
		$this->assertTrue( stripos( $response->headers, "Location:" ) !== false );
		$this->assertTrue( stripos( $response->headers, "/notification/".$recordId ) !== false );
		

		// verify insert was sucessful
		$response = $this->call('GET', '/api/v1/notification/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->to == $to );
		$this->assertTrue( $response->getData()->data->message == $message );
		$this->assertTrue( $response->getData()->data->reference == $reference );
		$this->assertTrue( $response->getData()->data->user_id == $user->id );

		// edit Notification
		$response = $this->call('PUT', '/api/v1/notification/'.$recordId, array('message' => $message."_changed") );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->message == $message."_changed" );
		$this->assertTrue( $response->getData()->message == 'Notification updated sucessfully!' );


		// verify update was sucessful
		$response = $this->call('GET', '/api/v1/notification/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->message == $message."_changed" );


		// make invalid update
		$response = $this->call('PUT', '/api/v1/notification/'.$recordId, array('message' => "x") );	// name is too short
		$this->assertFalse( $response->getData()->success );
		$this->assertTrue( $response->getData()->message == 'Error updating Notification!' );


		// now delete the notification
		$response = $this->call('DELETE', '/api/v1/notification/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->message == 'Notification deleted successfully!' );


		// verify delete was sucessful
		$response = $this->call('GET', '/api/v1/notification/'.$recordId );
		$this->assertFalse( $response->getData()->success );
		$this->assertTrue( stripos( $response->getData()->message, 'Could not find Notification with id' ) !== false );
		
	}
}