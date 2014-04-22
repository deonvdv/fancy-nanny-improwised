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

		//get Meal for today from database
		$found = \Models\Meal::where('household_id', '=', $user->household->id)->today()->get();
		$jd=cal_to_jd(CAL_GREGORIAN,date("m"),date("d"),date("Y"));
        $day_number = jddayofweek($jd) + 1;
        if($day_number == 1)
        {
        	$this->assertTrue(count($found) == 1);
        }
        else
        {
        	$this->assertTrue(count($found) == 0);
        }

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

	public function testMealValidation() {
    	$faker = \Faker\Factory::create();

		$user = parent::createFakeUserWithFakeHousehold();

		$newmeal = new \Models\Meal();
        $newmeal->week_number = 0;
        $newmeal->day_of_week = 0;
        $newmeal->slot = "xx";

		// var_dump( $newmeal->validate() );
		// var_dump( $newmeal->errors() );
		$this->assertFalse( $newmeal->validate() );
		// print_r( $newmeal->errors()->first("name") );
		// print_r( $newmeal->errors()->first("file_name") );
		// print_r( $newmeal->errors()->first("household_id") );
		// print_r( $newmeal->errors()->first("owner_id") );

		$this->assertTrue( $newmeal->errors()->first("household_id") == "The household id field is required." );
		$this->assertTrue( $newmeal->errors()->first("week_number") == "The week number must be between 1 and 52." );
		$this->assertTrue( $newmeal->errors()->first("day_of_week") == "The day of week must be between 1 and 7." );
		$this->assertTrue( $newmeal->errors()->first("slot") == "The slot must be at least 3 characters." );

		$newmeal->week_number = 1;
		$newmeal->day_of_week = 1;
		$newmeal->slot = 'lunch';

		// Associate household 
		$newmeal->household()->associate($user->household);

		// var_dump( $newmeal->validate() );
		// var_dump( $newmeal->errors() );
		$this->assertTrue( $newmeal->validate() );
		unset($newmeal);

	}

	public function testInvalidMealCannotSave() {

		$model = new \Models\Meal();
		$model->week_number = 0;

		$this->assertFalse( $model->save() );
	}

}