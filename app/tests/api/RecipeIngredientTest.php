<?php

class RecipeIngredientAPITest extends TestCase {

	public function testRecipeIngredientsAPI()
	{
		$crawler = $this->client->request('GET', '/api/v1/recipe_ingredients');
		$this->assertTrue($this->client->getResponse()->isOk());
	}   

	public function testStoreGetUpdateAndDeleteRecipeIngredient() {
		$faker = \Faker\Factory::create();
		$recipe = parent::createFakeRecipe();
		$quantity = 3.5;
		$unitOfMeasure = \Models\UnitOfMeasure::where('name', 'like', 'cup')->first();
		$ingredient = \Models\Ingredient::where('name', 'like', 'flour')->first();
		

		$response = $this->call('POST', '/api/v1/recipe_ingredient', array('recipe_id' => $recipe->id,
											'quantity'	=>	$quantity,
											'unit_of_measure_id'	=> $unitOfMeasure->id,
											'ingredient_id'	=>	$ingredient->id) );
		$recordId = $response->getData()->data->id;

		// Test that record was added
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $recordId != '' );
		$this->assertTrue( $response->getData()->data->recipe_id == $recipe->id );
		$this->assertTrue( $response->getData()->data->quantity == $quantity );
		$this->assertTrue( $response->getData()->data->unit_of_measure_id == $unitOfMeasure->id );
		$this->assertTrue( $response->getData()->data->ingredient_id == $ingredient->id );
		$this->assertTrue( $response->getData()->message == 'New RecipeIngredient created sucessfully!' );


		// test that location header is set
		$this->assertTrue( stripos( $response->headers, "Location:" ) !== false );
		$this->assertTrue( stripos( $response->headers, "/recipe_ingredient/".$recordId ) !== false );
		

		// verify insert was sucessful
		$response = $this->call('GET', '/api/v1/recipe_ingredient/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->recipe_id == $recipe->id );
		$this->assertTrue( $response->getData()->data->quantity == $quantity );
		$this->assertTrue( $response->getData()->data->unit_of_measure_id == $unitOfMeasure->id );
		$this->assertTrue( $response->getData()->data->ingredient_id == $ingredient->id );

		// edit recipe_ingredient
		$quantity = 5.5;
		$response = $this->call('PUT', '/api/v1/recipe_ingredient/'.$recordId, array(
													'quantity' => $quantity) );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->quantity == $quantity );
		$this->assertTrue( $response->getData()->message == 'RecipeIngredient updated sucessfully!' );


		// verify update was sucessful
		$response = $this->call('GET', '/api/v1/recipe_ingredient/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->quantity == $quantity );;


		// make invalid update
		$response = $this->call('PUT', '/api/v1/recipe_ingredient/'.$recordId, array('recipe_id' => $faker->uuid) );	// name is too short
		$this->assertFalse( $response->getData()->success );
		$this->assertTrue( $response->getData()->message == 'Error updating RecipeIngredient!' );


		// now delete the recipe_ingredient
		$response = $this->call('DELETE', '/api/v1/recipe_ingredient/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->message == 'RecipeIngredient deleted successfully!' );


		// verify delete was sucessful
		$response = $this->call('GET', '/api/v1/recipe_ingredient/'.$recordId );
		$this->assertFalse( $response->getData()->success );
		$this->assertTrue( stripos( $response->getData()->message, 'Could not find RecipeIngredient with id' ) !== false );
		 

	}
}