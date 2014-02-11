<?php

use \Models;

class UnitOfMeasureModelTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanCreateUnitOfMeasureSaveRetrieveAndDelete()
	{
		// echo "\nUnitOfMeasure Test...\n";
		
    	$faker = \Faker\Factory::create();
		
		// Create UnitOfMeasure
		$unitofmeasure = new \Models\UnitOfMeasure();
		$unitofmeasure->name = substr($faker->name,0,50);
		$unitofmeasure->alias = $faker->name;
		$unitofmeasure->preferred_alias = substr($faker->name,0,50);
		
		$unitofmeasure->save();

		$id = $unitofmeasure->id;

		// Get UnitOfMeasure from database
		$found = \Models\UnitOfMeasure::where('id', '=', $id)->firstOrFail();
		

		$this->assertTrue($found->id == $id);

		// Test UnitOfMeasure
		$this->assertTrue($found->id == $unitofmeasure->id);
		$this->assertTrue($found->name == $unitofmeasure->name);
		$this->assertTrue($found->alias == $unitofmeasure->alias);
		$this->assertTrue($found->preferred_alias == $unitofmeasure->preferred_alias);

		// Delete
		$this->assertTrue($found->delete());
	}

	public function testUnitOfMeasureValidation() {
    	$faker = \Faker\Factory::create();

		$newUnitOfMeasure = new \Models\UnitOfMeasure();
		$newUnitOfMeasure->name = "";
		$newUnitOfMeasure->alias = "";
		$newUnitOfMeasure->preferred_alias = "";

		$this->assertFalse( $newUnitOfMeasure->validate() );
		//echo( $newUnitOfMeasure->errors()->first("name") );
		$this->assertTrue( $newUnitOfMeasure->errors()->first("name") == "The name field is required." );
		$this->assertTrue( $newUnitOfMeasure->errors()->first("alias") == "The alias field is required." );
		$this->assertTrue( $newUnitOfMeasure->errors()->first("preferred_alias") == "The preferred alias field is required." );

		//$this->assertTrue( $newUnitOfMeasure->errors()->first("alias") == "The alias must be at least 3 characters." );
		//$this->assertTrue( $newUnitOfMeasure->errors()->first("preferred_alias") == "The preferred alias must be at least 3 characters." );

		$newUnitOfMeasure->name = $faker->sentence(200);
		$newUnitOfMeasure->alias = $faker->sentence(200);
		$newUnitOfMeasure->preferred_alias = $faker->sentence(200);

		$this->assertFalse( $newUnitOfMeasure->validate() );
		// var_dump( $newUnitOfMeasure->errors() );
		// print_r( $newUnitOfMeasure->errors()->first("name") );
		$this->assertTrue( $newUnitOfMeasure->errors()->first("name") == "The name may not be greater than 50 characters." );
		$this->assertTrue( $newUnitOfMeasure->errors()->first("alias") == "The alias may not be greater than 255 characters." );
		$this->assertTrue( $newUnitOfMeasure->errors()->first("preferred_alias") == "The preferred alias may not be greater than 255 characters." );

		$newUnitOfMeasure->name = $faker->text(20);
		$newUnitOfMeasure->alias = $faker->text(100);
		$newUnitOfMeasure->preferred_alias = $faker->text(100);
		$this->assertTrue( $newUnitOfMeasure->validate() );

		unset($newUnitOfMeasure);
	}

	public function testInvalidUnitOfMeasureCannotSave() {

		$model = new \Models\UnitOfMeasure();
		$model->name = "aa";

		$this->assertFalse( $model->validate() );
	}

}