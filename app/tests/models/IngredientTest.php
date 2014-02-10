<?php

use \Models;

class IngredientModelTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanCreateIngredientSaveRetrieveAndDelete()
	{
		// echo "\nIngredient Test...\n";
		
    	$faker = \Faker\Factory::create();
		
		$newIngredient = new \Models\Ingredient();

		$newIngredient->name = "Test Ingredient";
		$newIngredient->save();

		$id = $newIngredient->id;

		//get newIngredient from database
		$found = \Models\Ingredient::where('id', '=', $id)->firstOrFail();
		
		$this->assertTrue($found->id == $id);

		// Test Ingredient
		$this->assertTrue($found->id == $newIngredient->id);		
		$this->assertTrue($found->name == $newIngredient->name);

		// Delete
		$this->assertTrue($found->delete());
	}

	public function testIngredientValidation() {
    	$faker = \Faker\Factory::create();

		$newIngredient = new \Models\Ingredient();
		$newIngredient->name = "aa";

		$this->assertFalse( $newIngredient->validate() );
		// echo( $newIngredient->errors()->first("name") );
		$this->assertTrue( $newIngredient->errors()->first("name") == "The name must be at least 3 characters." );

		$newIngredient->name = $faker->sentence(200);

		$this->assertFalse( $newIngredient->validate() );
		// print_r( $newIngredient->errors()->first("name") );
		$this->assertTrue( $newIngredient->errors()->first("name") == "The name may not be greater than 255 characters." );

		$newIngredient->name = $faker->text(100);
		$this->assertTrue( $newIngredient->validate() );

		unset($newIngredient);
	}

	public function testInvalidIngredientCannotSave() {

		$model = new \Models\Ingredient();
		$model->name = "aa";

		$this->assertFalse( $model->save() );
	}

}