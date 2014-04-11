<?php

class MessageAPITest extends TestCase {

	public function tesMessagesAPI()
	{
		$crawler = $this->client->request('GET', '/api/v1/messages');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testStoreGetUpdateAndDeleteMessage() {
		$faker = \Faker\Factory::create();
		$sender = parent::createFakeUser();
		$receiver = parent::createFakeUser();

		$sender_id = $sender->id; 
		$receiver_id = $receiver->id; 
		$message = $faker->paragraph($nbSentences = 5);
		
		$response = $this->call('POST', '/api/v1/message', 
						array('sender_id' => $sender_id,
							  'receiver_id' => $receiver_id,
							  'message' => $message) );
		$recordId = $response->getData()->data->id;

		// Test that record was added
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $recordId != '' );
		$this->assertTrue( $response->getData()->data->sender_id == $sender_id );
		$this->assertTrue( $response->getData()->data->receiver_id == $receiver_id );
		$this->assertTrue( $response->getData()->data->message == $message );
		$this->assertTrue( $response->getData()->message == 'New Message created sucessfully!' );

		// test that location header is set
		$this->assertTrue( stripos( $response->headers, "Location:" ) !== false );
		$this->assertTrue( stripos( $response->headers, "/message/".$recordId ) !== false );
		
		// verify that unread is returned
		$response = $this->call('GET', '/api/v1/message/'.$receiver_id. '/unread' );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data[0]->id == $recordId );
		$this->assertTrue( $response->getData()->data[0]->sender_id == $sender_id );
		$this->assertTrue( $response->getData()->data[0]->receiver_id == $receiver_id );
		$this->assertTrue( $response->getData()->data[0]->message == $message );		
		
		// verify insert was sucessful
		$response = $this->call('GET', '/api/v1/message/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->sender_id == $sender_id );
		$this->assertTrue( $response->getData()->data->receiver_id == $receiver_id );
		$this->assertTrue( $response->getData()->data->message == $message );

		// edit message
		$response = $this->call('PUT', '/api/v1/message/'.$recordId, array('message' => $message."_changed") );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->message == $message."_changed" );
		$this->assertTrue( $response->getData()->message == 'Message updated sucessfully!' );


		// verify update was sucessful
		$response = $this->call('GET', '/api/v1/message/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->message == $message."_changed" );


		// make invalid update
		$response = $this->call('PUT', '/api/v1/message/'.$recordId, array('message' => "") );	// name is too short
		$this->assertFalse( $response->getData()->success );
		$this->assertTrue( $response->getData()->message == 'Error updating Message!' );


		// now delete the message
		$response = $this->call('DELETE', '/api/v1/message/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->message == 'Message deleted successfully!' );


		// verify delete was sucessful
		$response = $this->call('GET', '/api/v1/message/'.$recordId );
		$this->assertFalse( $response->getData()->success );
		$this->assertTrue( stripos( $response->getData()->message, 'Could not find Message with id' ) !== false );
		 
	}
}