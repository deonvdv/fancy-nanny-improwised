<?php

use \Models;

class MealModelTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanCreateMealSaveRetrieveAndDelete()
	{
		// echo "\nMeal Test...\n";
		
    	$faker = \Faker\Factory::create();
		
		// Get the owner
		$user = parent::createFakeUserWithFakeHousehold();

		$newmeal = new \Models\Meal();
		$newmeal->week_number = 1;
		$newmeal->day_of_week = 1;
		$newmeal->slot = 'lunch';

		// Associate household 
		$newmeal->household()->associate($user->household);
		
		$newmeal->save();

		$id = $newmeal->id;

		//get Meal from database
		$found = \Models\Meal::where('id', '=', $id)->firstOrFail();
		// print_r($found);
		// echo "\nFound Id: " . $found->id . "\n";

		$this->assertTrue($found->id == $id);

		// Test Meal
		$this->assertTrue($found->id == $newmeal->id);		
		$this->assertTrue($found->week_number == $newmeal->week_number);
		$this->assertTrue($found->day_of_week == $newmeal->day_of_week);
		$this->assertTrue($found->slot == $newmeal->slot);

		// Test Household
		$this->assertTrue($found->household->id == $user->household->id);

		// Delete
		$this->assertTrue( $found->delete() );
	}

}