<?php

use \Models;

class NotificationModelTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanCreateNotificationSaveRetrieveAndDelete()
	{
		// echo "\nNotification Test...\n";
		
    	$faker = \Faker\Factory::create();

    	// Get Member
		$user = parent::createFakeUserWithFakeHousehold();

		$notification = new \Models\Notification();
		$notification->to = $faker->email;
		$notification->message = $faker->name;
		$notification->reference = $faker->uuid();
		$notification->setUser( $user );
		$notification->save();

		$id = $notification->id;

		//Get Notification from database
		$found = \Models\Notification::where('id', '=', $id)->firstOrFail();
		
		$this->assertTrue($found->id == $id);

		// Test Notification
		$this->assertTrue($found->id == $notification->id);		
		$this->assertTrue($found->user_id == $user->id);		
		$this->assertTrue($found->to == $notification->to);
		$this->assertTrue($found->message == $notification->message);
		$this->assertTrue($found->reference == $notification->reference);

		//Test Household
		$this->assertTrue($found->household->id == $user->household->id);

		// echo "\nNotification Test: User Id: " . $user->id;
		// echo "\nNotification Test: User Household Id: " . $user->household->id . "\n";

		// Delete
		$this->assertTrue($found->delete());

	}

	public function testNotificationValidation() {
    	$faker = \Faker\Factory::create();

		$user = parent::createFakeUserWithFakeHousehold();

		$notification = new \Models\Notification();
        $notification->to = "aa";
        $notification->message = "aa";

		$this->assertFalse( $notification->validate() );
		// var_dump( $notification->validate() );
		// var_dump( $notification->errors() );
		// print_r( $notification->errors()->first("name") );
		// print_r( $notification->errors()->first("file_name") );
		// print_r( $notification->errors()->first("household_id") );
		// print_r( $notification->errors()->first("owner_id") );

		$this->assertTrue( $notification->errors()->first("to") == "The to must be at least 3 characters." );
		$this->assertTrue( $notification->errors()->first("message") == "The message must be at least 3 characters." );
		$this->assertTrue( $notification->errors()->first("household_id") == "The household id field is required." );
		$this->assertTrue( $notification->errors()->first("user_id") == "The user id field is required." );

		$notification->to = $faker->text(100);
		$notification->message = $faker->text(100);
		// set Owner
        $notification->setUser( $user );

		$this->assertTrue( $notification->validate() );

	}

	public function testInvalidNotificationCannotSave() {

		$model = new \Models\Notification();
		$model->to = "aa";

		$this->assertFalse( $model->validate() );
	}

}