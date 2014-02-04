<?php

class UnitOfMeasureTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanCreateUnitOfMeasureSaveRetrieveAndDelete()
	{

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

}