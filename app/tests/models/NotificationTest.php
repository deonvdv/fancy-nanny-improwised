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

}