<?php

class RecipeIngredientTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanCreateRecipeIngredientSaveAndRetrieve()
	{

    	$faker = \Faker\Factory::create();

    	$recipe = \Models\Recipe::firstOrFail();
    	$this->assertNotNull( $recipe );

		
		$ri = new \Models\RecipeIngredient();

		$ri->setRecipe( $recipe );
		$ri->quantity = 3.5;
		$ri->setUnitOfMeasure( \Models\UnitOfMeasure::where('name', 'like', 'cup')->first() );
		$ri->setIngredient( \Models\Ingredient::where('name', 'like', 'flour')->first() );
		$ri->save();

		$id = $ri->id;

		$this->assertTrue($ri->id != "");

		//get newRecipeIngredient from database
		$found = \Models\RecipeIngredient::where('id', '=', $id)->with('unit_of_measure', 'ingredient')->firstOrFail();
		// print_r( $found );
		// echo "\nFound Id: " . $found->id . "\n";

		$this->assertTrue($found->id == $id);

		// Test UnitOfMeasure
		$this->assertTrue($found->id == $ri->id);		
		$this->assertTrue( count( $found->unit_of_measure ) == 1 );
		$this->assertTrue( $found->unit_of_measure->name == "cup" );

		// Test Ingredient
		$this->assertTrue( count( $found->ingredient ) == 1 );
		$this->assertTrue( $found->ingredient->name == "Flour" );

		// Test Quantity
		$this->assertTrue( $found->quantity == 3.5 );

		// Delete
		$this->assertTrue( $found->delete() );

	}

}