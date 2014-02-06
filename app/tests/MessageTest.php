<?php

class MessageTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanCreateMessageSaveRetrieveAndDelete()
	{

    	$faker = \Faker\Factory::create();
		
		// Get the sender
		$sender = \Models\User::where('name', '=', 'Deon van der Vyver')->first();

		// Get the receiver
		$receiver = \Models\User::where('name', 'like', '%seed user')->first();
			
		// Get household
		$household = \Models\Household::where('name','like','%household')->first();

		$newmessage = new \Models\Message();
		//Set Household
		$newmessage->household()->associate($household);
		$newmessage->message = $faker->text;
		//Set Sender
		$newmessage->sender()->associate($sender);
		//Set Receiver
		$newmessage->receiver()->associate($receiver);
		$newmessage->save();

		$id = $newmessage->id;

		//get Message from database
		$found = \Models\Message::where('id', '=', $id)->firstOrFail();
		
		$this->assertTrue($found->id == $id);

		// Test Message
		$this->assertTrue($found->id == $newmessage->id);
		$this->assertTrue($found->name == $newmessage->name);

		// Test Household
		$this->assertTrue($found->household_id == $newmessage->household_id);
		$this->assertTrue($found->household->id == $newmessage->household_id);
		$this->assertTrue($found->household->id == $household->id);

		// Test Sender
		$this->assertTrue($found->sender_id == $newmessage->sender_id);
		$this->assertTrue($found->sender->id == $newmessage->sender_id);
		$this->assertTrue($found->sender->id == $sender->id);

		// Test Receiver
		$this->assertTrue($found->receiver_id == $newmessage->receiver_id);
		$this->assertTrue($found->receiver->id == $newmessage->receiver_id);
		$this->assertTrue($found->receiver->id == $receiver->id);

		// Delete
		$this->assertTrue( $found->delete() );
	}

}