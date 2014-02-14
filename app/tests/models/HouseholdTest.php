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

		$id = $household->id;

		//get Household from database
		$found = \Models\Household::where('id', '=', $id)->firstOrFail();
	
		$this->assertTrue($found->id == $id);

		// Test Household
		$this->assertTrue($found->id == $household->id);		
		$this->assertTrue($found->emergency_contacts == $household->emergency_contacts);
		$this->assertTrue($found->critical_information == $household->critical_information);
		
		//Test members
		$this->assertTrue(count($found->members) == 1);
		$this->assertTrue($found->members[0]->id == $user->id );
		$this->assertTrue($found->members[0]->household->id == $user->household->id );

		// echo "\nHousehold Test: User Id: " . $user->id;
		// echo "\nHousehold Test: User Household Id: " . $user->household->id . "\n";

		// Delete
		$this->assertTrue($found->delete());
	}

	public function testHouseholdValidation() {
    	$faker = \Faker\Factory::create();

		$household = new \Models\Household();
        $household->name = "aa";
       
		$this->assertFalse( $household->validate() );
		//print_r( $household->errors()->first("name") );
		
		$this->assertTrue( $household->errors()->first("name") == "The name must be between 4 and 255 characters." );
		
		$household->name = $faker->text(100);
		
        $this->assertTrue( $household->validate() );
        unset($household);

	}

	public function testInvalidDocumentCannotSave() {

		$model = new \Models\Household();
		$model->name = "aa";

		$this->assertFalse( $model->save() );
	}

}