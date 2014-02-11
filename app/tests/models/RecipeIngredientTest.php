<?php

use \Models;

class RecipeIngredientModelTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanCreateRecipeIngredientSaveRetrieveAndDelete()
	{
		// echo "\nRecipeIngredient Test...\n";
		
    	$faker = \Faker\Factory::create();

    	$recipe = parent::createFakeRecipe();

    	$this->assertNotNull( $recipe );

		
		$ri = new \Models\RecipeIngredient();
		$ri->quantity = 3.5;
		$ri->setUnitOfMeasure( \Models\UnitOfMeasure::where('name', 'like', 'cup')->first() );
		$ri->setIngredient( \Models\Ingredient::where('name', 'like', 'flour')->first() );
		$ri->setRecipe( $recipe );
		$ri->save();
		$id = $ri->id;

		$this->assertTrue($ri->id != "");

		//get newRecipeIngredient from database
		$found = \Models\RecipeIngredient::where('id', '=', $id)->with('unit_of_measure', 'ingredient')->firstOrFail();
		// print_r( $found );
		// echo "\nFound Id: " . $found->id . "\n";

		$this->assertTrue($found->id == $id);
		$this->assertTrue($found->recipe->id == $recipe->id);

		// Test UnitOfMeasure
		$this->assertTrue( $found->id == $ri->id );		
		$this->assertTrue( $found->unit_of_measure->name == "cup" );

		// Test Ingredient
		$this->assertTrue( $found->ingredient->name == "Flour" );

		// Test Quantity
		$this->assertTrue( $found->quantity == 3.5 );

		// Delete
		$this->assertTrue( $found->delete() );

	}

	public function testRecipeIngredientValidation() {
    	$faker = \Faker\Factory::create();

		$recipe = parent::createFakeRecipe();

		$ri = new \Models\RecipeIngredient();
       
       	$this->assertFalse( $ri->validate() );

       	// print_r($ri->errors()->first("recipe_id"));
       	// print_r($ri->errors()->first("quantity"));
       	// print_r($ri->errors()->first("unit_of_measure_id"));
       	// print_r($ri->errors()->first("ingredient_id"));

		$this->assertTrue( $ri->errors()->first("recipe_id") == "The recipe id field is required." );
		$this->assertTrue( $ri->errors()->first("quantity") == "The quantity field is required." );
		$this->assertTrue( $ri->errors()->first("unit_of_measure_id") == "The unit of measure id field is required." );
		$this->assertTrue( $ri->errors()->first("ingredient_id") == "The ingredient id field is required." );

		$ri->quantity = 2;
		$ri->setUnitOfMeasure( \Models\UnitOfMeasure::where('name', 'like', 'cup')->first() );
		$ri->setIngredient( \Models\Ingredient::where('name', 'like', 'flour')->first() );
		$ri->setRecipe($recipe);
		$this->assertTrue( $ri->validate() );
		unset($ri);
	}

	public function testInvalidRecipeIngredientCannotSave() {

		$model = new \Models\RecipeIngredient();
		$model->quantity = 5;

		$this->assertFalse( $model->save() );
	}
}