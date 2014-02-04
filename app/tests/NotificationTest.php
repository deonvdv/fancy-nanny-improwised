<?php

class NotificationTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanCreateNotificationSaveRetrieveAndDelete()
	{

    	$faker = \Faker\Factory::create();

    	// Get Member
		$user = \Models\User::where('name', '=', 'Deon van der Vyver')->first();

		// Get Household
		$household = \Models\Household::where('name','like','%household')->first();

		$newNotification = new \Models\Notification();
		$newNotification->household_id = $household->id;
		$newNotification->user_id = $user->id;		
		$newNotification->to = $faker->email;
		$newNotification->message = $faker->name;
		$newNotification->reference = $household->name;
		$newNotification->save();

		$id = $newNotification->id;

		//Get Notification from database
		$found = \Models\Notification::where('id', '=', $id)->firstOrFail();
		
		$this->assertTrue($found->id == $id);

		// Test Household
		$this->assertTrue($found->id == $newNotification->id);		
		$this->assertTrue($found->to == $newNotification->to);
		$this->assertTrue($found->message == $newNotification->message);
		$this->assertTrue($found->reference == $newNotification->reference);

		// Delete
		$this->assertTrue($found->delete());

	}

}