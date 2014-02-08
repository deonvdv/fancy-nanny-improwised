<?php

use \Models;

class MessageModelTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanCreateMessageSaveRetrieveAndDelete()
	{
		// echo "\nMessage Test...\n";
		
    	$faker = \Faker\Factory::create();
		
		// Get the sender
		$sender = parent::createFakeUserWithFakeHousehold();

		// Get the receiver
		$receiver = parent::createFakeUser($sender->household);
			
		$msg = new \Models\Message();

		//Set Household
		$msg->setHousehold( $sender->household );
		$msg->message = $faker->text;
		$msg->setSender( $sender );
		$msg->setReceiver( $receiver );

		$msg->save();

		$id = $msg->id;

		//get Message from database
		$found = \Models\Message::where('id', '=', $id)->firstOrFail();
		
		$this->assertTrue($found->id == $id);

		// Test Message
		$this->assertTrue($found->id == $msg->id);
		$this->assertTrue($found->name == $msg->name);

		// Test Household
		$this->assertTrue($found->household->id == $sender->household->id);

		// Test Sender
		$this->assertTrue($found->sender->id == $sender->id);

		// Test Receiver
		$this->assertTrue($found->receiver->id == $receiver->id);

		// echo "\nMessage Test: Sender Id: " . $sender->id;
		// echo "\nMessage Test: Sender Household Id: " . $sender->household->id . "\n";

		// Delete
		$this->assertTrue( $found->delete() );
	}

	public function testMessageValidation() {
    	$faker = \Faker\Factory::create();

		$user = parent::createFakeUserWithFakeHousehold();

		$msg = new \Models\Message();

		$this->assertFalse( $msg->validate() );
		// var_dump( $msg->validate() );
		// var_dump( $msg->errors() );
		// print_r( $msg->errors()->first("name") );
		// print_r( $msg->errors()->first("file_name") );
		// print_r( $msg->errors()->first("household_id") );
		// print_r( $msg->errors()->first("owner_id") );

		$this->assertTrue( $msg->errors()->first("household_id") == "The household id field is required." );
		$this->assertTrue( $msg->errors()->first("sender_id") == "The sender id field is required." );
		$this->assertTrue( $msg->errors()->first("message") == "The message field is required." );

		$msg->setHousehold( $user->household );
		$msg->message = $faker->text(100);
		$msg->setSender( $user );
		$msg->setReceiver( $user );

		// var_dump( $msg->validate() );
		// var_dump( $msg->errors() );
		$this->assertTrue( $msg->validate() );

	}

	public function testInvalidMessageCannotSave() {

		$model = new \Models\Message();
		$model->message = "aa";

		$this->assertFalse( $model->validate() );
	}

}