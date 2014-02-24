<?php

class RecipeAPITest extends TestCase {

	public function testRecipesAPI()
	{
		$crawler = $this->client->request('GET', '/api/v1/recipes');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testStoreGetUpdateAndDeleteRecipe() {
		$faker = \Faker\Factory::create();

		$name = $faker->name;
		$description = $faker->text;
		$instructions = $faker->text;
		$number_of_portions = $faker->randomDigit;
		$preparation_time = $faker->time;
		$cooking_time = $faker->time;
		$user = parent::createFakeUser();
		
		$response = $this->call('POST', '/api/v1/recipe', array('name' => $name ,
											'description' => $description,
											'instructions' => $instructions,
											'number_of_portions' => $number_of_portions,
											'preparation_time' => $preparation_time,
											'cooking_time' => $cooking_time,
											'author_id' => $user->id) );
		$recordId = $response->getData()->data->id;

		// Test that record was added
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $recordId != '' );
		$this->assertTrue( $response->getData()->data->name == $name );
		$this->assertTrue( $response->getData()->data->description == $description );
		$this->assertTrue( $response->getData()->data->instructions == $instructions );
		$this->assertTrue( $response->getData()->data->number_of_portions == $number_of_portions );
		$this->assertTrue( $response->getData()->data->preparation_time == $preparation_time );
		$this->assertTrue( $response->getData()->data->cooking_time == $cooking_time );
		$this->assertTrue( $response->getData()->data->author_id == $user->id );
		$this->assertTrue( $response->getData()->message == 'New Recipe created sucessfully!' );


		// test that location header is set
		$this->assertTrue( stripos( $response->headers, "Location:" ) !== false );
		$this->assertTrue( stripos( $response->headers, "/recipe/".$recordId ) !== false );
		

		// verify insert was sucessful
		$response = $this->call('GET', '/api/v1/recipe/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->name == $name );
		$this->assertTrue( $response->getData()->data->description == $description );
		$this->assertTrue( $response->getData()->data->instructions == $instructions );
		$this->assertTrue( $response->getData()->data->number_of_portions == $number_of_portions );
		$this->assertTrue( $response->getData()->data->preparation_time == $preparation_time );
		$this->assertTrue( $response->getData()->data->cooking_time == $cooking_time );
		$this->assertTrue( $response->getData()->data->author_id == $user->id );

		// edit recipe
		$response = $this->call('PUT', '/api/v1/recipe/'.$recordId, array('name' => $name."_changed") );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->name == $name."_changed" );
		$this->assertTrue( $response->getData()->message == 'Recipe updated sucessfully!' );


		// verify update was sucessful
		$response = $this->call('GET', '/api/v1/recipe/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->name == $name."_changed" );


		// make invalid update
		$response = $this->call('PUT', '/api/v1/recipe/'.$recordId, array('name' => "x") );	// name is too short
		$this->assertFalse( $response->getData()->success );
		$this->assertTrue( $response->getData()->message == 'Error updating Recipe!' );

		//Get relevant recipe_ingredients
		$response = $this->call('GET', '/api/v1/recipe/'.$recordId.'/recipe_ingredients/' );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( stripos( $response->getData()->message, 'No records found in this collection.' ) !== false );
		
		//Get relevant pictures
		$response = $this->call('GET', '/api/v1/recipe/'.$recordId.'/pictures/' );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( stripos( $response->getData()->message, 'No records found in this collection.' ) !== false );
		
		//Get relevant tags
		$response = $this->call('GET', '/api/v1/recipe/'.$recordId.'/tags/' );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( stripos( $response->getData()->message, 'No records found in this collection.' ) !== false );
		
		//Get relevant reviews
		$response = $this->call('GET', '/api/v1/recipe/'.$recordId.'/reviews/' );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( stripos( $response->getData()->message, 'No records found in this collection.' ) !== false );
		
		// now delete the recipe
		$response = $this->call('DELETE', '/api/v1/recipe/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->message == 'Recipe deleted successfully!' );

		// verify delete was sucessful
		$response = $this->call('GET', '/api/v1/recipe/'.$recordId );
		$this->assertFalse( $response->getData()->success );
		$this->assertTrue( stripos( $response->getData()->message, 'Could not find Recipe with id' ) !== false );
		
	}
}