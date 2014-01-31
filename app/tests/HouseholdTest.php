<?php

class HouseholdTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanCreateHouseholdSaveAndRetrieve()
	{

    	$faker = \Faker\Factory::create();

    	// Get Member
		$user = \Models\User::where('name', '=', 'Deon van der Vyver')->first();
		
		$newHousehold = new \Models\Household();

		$newHousehold->name = "Test Household";		
		$newHousehold->save();

		$newHousehold->members()->save($user);

		$id = $newHousehold->id;

		//get Household from database
		$found = \Models\Household::with(array('members'))->where('id', '=', $id)->firstOrFail();
		
		$this->assertTrue($found->id == $id);

		// Test Household
		$this->assertTrue($found->id == $newHousehold->id);		
		$this->assertTrue($found->name == $newHousehold->name);

	}

}