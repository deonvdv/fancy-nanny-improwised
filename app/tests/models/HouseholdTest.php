<?php

use \Models;

class HouseholdModelTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanCreateHouseholdSaveRetrieveAndDelete()
	{
		// echo "\nHousehold Test...\n";
		
    	$faker = \Faker\Factory::create();

        $user = parent::createFakeUser();

        $household = parent::createFakeHousehold();
	
        // Add Members
        // Note: remember to add user to household before adding documets etc
		$household->addMember( $user );

		// Add Documents
		$doc = parent::createFakeDocument();
		$doc->setOwner( $user );
        $household->addDocument( $doc );

		//Add Messages
		$msg = parent::createFakeMessage($user, $user);
		$household->addMessage( $msg );

		//Add Tags
		$tag = parent::createFakeTag();
		$tag->setOwner( $user );
		$household->addTag( $tag );


		$id = $household->id;

		//get Household from database
		$found = \Models\Household::where('id', '=', $id)->firstOrFail();
	
		$this->assertTrue($found->id == $id);

		// Test Household
		$this->assertTrue($found->id == $household->id);		
		$this->assertTrue($found->emergency_contacts == $household->emergency_contacts);
		$this->assertTrue($found->critical_information == $household->critical_information);
		
		//Test documents
		$this->assertTrue(count($found->documents) == 1);
		$this->assertTrue($found->documents[0]->owner->id == $user->id );
		$this->assertTrue($found->documents[0]->owner->household->id == $user->household->id );

		//Test members
		$this->assertTrue(count($found->members) == 1);
		$this->assertTrue($found->members[0]->id == $user->id );
		$this->assertTrue($found->members[0]->household->id == $user->household->id );

		//Test messages
		$this->assertTrue(count($found->messages) == 1 );
		$this->assertTrue($found->messages[0]->sender->id == $user->id );
		$this->assertTrue($found->messages[0]->sender->household->id == $user->household->id );

		//Test tags
		$this->assertTrue(count($found->tags) == 1 );
		$this->assertTrue($found->tags[0]->owner->id == $user->id );


		// echo "\nHousehold Test: User Id: " . $user->id;
		// echo "\nHousehold Test: User Household Id: " . $user->household->id . "\n";

		// Delete
		$this->assertTrue($found->delete());
	}

}