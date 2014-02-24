<?php

class IngredientAPITest extends TestCase {

	public function testIngredientsAPI()
	{
		$crawler = $this->client->request('GET', '/api/v1/ingredients');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testStoreGetUpdateAndDeleteIngredient() {
		$faker = \Faker\Factory::create();

		$ingredientName = $faker->bs;

		$response = $this->call('POST', '/api/v1/ingredient', array('name' => $ingredientName) );
		$recordId = $response->getData()->data->id;

		// Test that record was added
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $recordId != '' );
		$this->assertTrue( $response->getData()->data->name == $ingredientName );
		$this->assertTrue( $response->getData()->message == 'New Ingredient created sucessfully!' );


		// test that location header is set
		$this->assertTrue( stripos( $response->headers, "Location:" ) !== false );
		$this->assertTrue( stripos( $response->headers, "/ingredient/".$recordId ) !== false );
		

		// verify insert was sucessful
		$response = $this->call('GET', '/api/v1/ingredient/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->name == $ingredientName );


		// edit ingredient
		$response = $this->call('PUT', '/api/v1/ingredient/'.$recordId, array('name' => $ingredientName."_changed") );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->name == $ingredientName."_changed" );
		$this->assertTrue( $response->getData()->message == 'Ingredient updated sucessfully!' );


		// verify update was sucessful
		$response = $this->call('GET', '/api/v1/ingredient/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->name == $ingredientName."_changed" );


		// make invalid update
		$response = $this->call('PUT', '/api/v1/ingredient/'.$recordId, array('name' => "x") );	// name is too short
		$this->assertFalse( $response->getData()->success );
		$this->assertTrue( $response->getData()->message == 'Error updating Ingredient!' );


		// now delete the ingredient
		$response = $this->call('DELETE', '/api/v1/ingredient/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->message == 'Ingredient deleted successfully!' );


		// verify delete was sucessful
		$response = $this->call('GET', '/api/v1/ingredient/'.$recordId );
		$this->assertFalse( $response->getData()->success );
		$this->assertTrue( stripos( $response->getData()->message, 'Could not find Ingredient with id' ) !== false );
		 
	}
}