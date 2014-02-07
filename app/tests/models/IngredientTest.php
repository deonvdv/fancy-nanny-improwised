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

		// Test Category
		$this->assertTrue($found->id == $newIngredient->id);		
		$this->assertTrue($found->name == $newIngredient->name);

		// Delete
		$this->assertTrue($found->delete());
	}

}