<?php

class HouseholdTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanCreateHouseholdSaveRetrieveAndDelete()
	{

    	$faker = \Faker\Factory::create();

    	// Get Member
		$user = \Models\User::where('name', '=', 'Deon van der Vyver')->first();
		
		// Contacts
		$contacts = ["Father", "Mother", "Sister", "Brother", "Aunt", "Uncle", "Grandfather", "Grandmother"];
		$emergency_contacts = json_encode( [ 
		        			$contacts[rand(0, 7)] => ["name" => $faker->name, "contact_number" => $faker->phoneNumber, "contact_email" => $faker->safeEmail], 
		        			$contacts[rand(0, 7)] => ["name" => $faker->name, "contact_number" => $faker->phoneNumber, "contact_email" => $faker->safeEmail], 
		        			$contacts[rand(0, 7)] => ["name" => $faker->name, "contact_number" => $faker->phoneNumber, "contact_email" => $faker->safeEmail], 
		        			$contacts[rand(0, 7)] => ["name" => $faker->name, "contact_number" => $faker->phoneNumber, "contact_email" => $faker->safeEmail], 
		        			] );

		$household = new \Models\Household();

		$household->name = $faker->unique()->lastName . " Household";
		$household->emergency_contacts = $emergency_contacts;
		$household->critical_information = $faker->paragraph($nbSentences = 3);

		// $household->save();
		$household->addDocument( new \Models\Document( array( 
										"name"      => ucwords($faker->bs), 
										"file_name" => $faker->word.'.'.$faker->fileExtension, 
										"owner_id"  => $user->id, 
										"private"   => false ) ) );
		$household->addMember( $user );
		$household->addMessage( new \Models\Message( array( 
										"sender_id" => $user->id, 
										"receiver_id" => $user->id, 
										"message" => $faker->paragraph($nbSentences = 5) ) ) );
		$household->addTag( new \Models\Tag( array( 
										'name'         => 'tag 4',
										'user_id'      => $user->id,
										'color'        => substr($faker->colorName,0,7) ) ) );


		$id = $household->id;

		//get Household from database
		$found = \Models\Household::where('id', '=', $id)->with(array('documents','members','messages','tags'))->firstOrFail();
		// print_r($found);
		// echo "\nFound Id: " . $found->id . "\n";
		
		$this->assertTrue($found->id == $id);

		// Test Household
		$this->assertTrue($found->id == $household->id);		
		$this->assertTrue($found->emergency_contacts == $household->emergency_contacts);
		$this->assertTrue($found->critical_information == $household->critical_information);
		$this->assertTrue(count($found->documents) == 1 );
		$this->assertTrue($found->documents[0]->owner->id == $user->id );
		$this->assertTrue(count($found->members) == 1 );
		$this->assertTrue($found->members[0]->id == $user->id );
		$this->assertTrue(count($found->messages) == 1 );
		$this->assertTrue($found->messages[0]->sender->id == $user->id );
		$this->assertTrue(count($found->tags) == 1 );
		$this->assertTrue($found->tags[0]->user->id == $user->id );



		// Delete
		$this->assertTrue($found->delete());

	}

}