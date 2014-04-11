<?php

class TodoAPITest extends TestCase {

	public function testTodosAPI()
	{
		$crawler = $this->client->request('GET', '/api/v1/todos');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testStoreGetUpdateAndDeleteTodo() {
		$faker = \Faker\Factory::create();

		$user = parent::createFakeUser();

		$title = "API TESTING";
		$description = $faker->text;
		$due_date = $faker->date;
		$is_complete = false;
		$notify	= $faker->word;
		$minutes_before = 20;
		

		$response = $this->call('POST', '/api/v1/todo', array('title' => $title,
										'description' => $description,
										'due_date'	=> $due_date,
										'is_complete' => $is_complete,
										'notify' => $notify,
										'minutes_before' => $minutes_before,
										'owner_id' => $user->id,
										'assigned_by' => $user->id,
										'assigned_to' => $user->id) );
		$recordId = $response->getData()->data->id;

		// Test that record was added
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $recordId != '' );
		$this->assertTrue( $response->getData()->data->title == $title );
		$this->assertTrue( $response->getData()->data->description == $description );
		$this->assertTrue( $response->getData()->data->due_date == $due_date );
		$this->assertTrue( $response->getData()->data->is_complete == $is_complete );
		$this->assertTrue( $response->getData()->data->notify == $notify );
		$this->assertTrue( $response->getData()->data->minutes_before == $minutes_before );
		$this->assertTrue( $response->getData()->data->owner_id == $user->id );
		$this->assertTrue( $response->getData()->data->assigned_by == $user->id );
		$this->assertTrue( $response->getData()->data->assigned_to == $user->id );
		$this->assertTrue( $response->getData()->message == 'New Todo created sucessfully!' );


		// test that location header is set
		$this->assertTrue( stripos( $response->headers, "Location:" ) !== false );
		$this->assertTrue( stripos( $response->headers, "/todo/".$recordId ) !== false );
		

		// verify insert was sucessful
		$response = $this->call('GET', '/api/v1/todo/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->title == $title );
		$this->assertTrue( $response->getData()->data->description == $description );
		$this->assertTrue( $response->getData()->data->due_date == $due_date );
		$this->assertTrue( $response->getData()->data->is_complete == $is_complete );
		$this->assertTrue( $response->getData()->data->notify == $notify );
		$this->assertTrue( $response->getData()->data->minutes_before == $minutes_before );
		$this->assertTrue( $response->getData()->data->owner_id == $user->id );
		$this->assertTrue( $response->getData()->data->assigned_by == $user->id );
		$this->assertTrue( $response->getData()->data->assigned_to == $user->id );

		// verify that remaining todo is returned
		$response = $this->call('GET', '/api/v1/todo/'.$user->id .'/remaining');
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->total_item == 1 );
		$this->assertTrue( $response->getData()->data[0]->title == $title );
		$this->assertTrue( $response->getData()->data[0]->description == $description );
		$this->assertTrue( $response->getData()->data[0]->due_date == $due_date );
		$this->assertTrue( $response->getData()->data[0]->is_complete == $is_complete );
		$this->assertTrue( $response->getData()->data[0]->notify == $notify );
		$this->assertTrue( $response->getData()->data[0]->minutes_before == $minutes_before );
		$this->assertTrue( $response->getData()->data[0]->owner_id == $user->id );
		$this->assertTrue( $response->getData()->data[0]->assigned_by == $user->id );
		$this->assertTrue( $response->getData()->data[0]->assigned_to == $user->id );

		// edit todo
		$response = $this->call('PUT', '/api/v1/todo/'.$recordId, array('title' => $title ."_changed") );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->title == $title."_changed" );
		$this->assertTrue( $response->getData()->message == 'Todo updated sucessfully!' );


		// verify update was sucessful
		$response = $this->call('GET', '/api/v1/todo/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->title == $title."_changed" );

		// make invalid update
		$response = $this->call('PUT', '/api/v1/todo/'.$recordId, array('title' => 'x') );	// title is too short
		$this->assertFalse( $response->getData()->success );
		$this->assertTrue( $response->getData()->message == 'Error updating Todo!' );

		//Get relevant tags
		$response = $this->call('GET', '/api/v1/todo/'.$recordId.'/tags/' );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( stripos( $response->getData()->message, 'No records found in this collection.' ) !== false );
		

		// now delete the todo
		$response = $this->call('DELETE', '/api/v1/todo/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->message == 'Todo deleted successfully!' );


		// verify delete was sucessful
		$response = $this->call('GET', '/api/v1/todo/'.$recordId );
		$this->assertFalse( $response->getData()->success );
		$this->assertTrue( stripos( $response->getData()->message, 'Could not find Todo with id' ) !== false );
		
		$this->assertTrue( $user->delete() );

	}
}