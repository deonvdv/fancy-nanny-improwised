<?php

class RecipeReviewAPITest extends TestCase {

	public function testRecipeReviewsAPI()
	{
		$crawler = $this->client->request('GET', '/api/v1/recipe_reviews');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testStoreGetUpdateAndDeleteRecipeReview() {
		$faker = \Faker\Factory::create();

		$recipe = parent::createFakeRecipe();
		$user = parent::createFakeUser();
		$reviewText = $faker->text;
		$score = 4;

		$response = $this->call('POST', '/api/v1/recipe_review', array('recipe_id' => $recipe->id,
													'user_id' => $user->id,
													'score'	 =>	$score,
													'review' =>	$reviewText) );
		$recordId = $response->getData()->data->id;

		// Test that record was added
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $recordId != '' );
		$this->assertTrue( $response->getData()->data->recipe_id == $recipe->id );
		$this->assertTrue( $response->getData()->data->user_id == $user->id );
		$this->assertTrue( $response->getData()->data->score == $score );
		$this->assertTrue( $response->getData()->data->review == $reviewText );
		$this->assertTrue( $response->getData()->message == 'New RecipeReview created sucessfully!' );


		// test that location header is set
		$this->assertTrue( stripos( $response->headers, "Location:" ) !== false );
		$this->assertTrue( stripos( $response->headers, "/recipe_review/".$recordId ) !== false );
		

		// verify insert was sucessful
		$response = $this->call('GET', '/api/v1/recipe_review/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->recipe_id == $recipe->id );
		$this->assertTrue( $response->getData()->data->user_id == $user->id );
		$this->assertTrue( $response->getData()->data->score == $score );
		$this->assertTrue( $response->getData()->data->review == $reviewText );

		// edit recipe_review
		$response = $this->call('PUT', '/api/v1/recipe_review/'.$recordId, 
													array('review' => $reviewText."_changed") );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->review == $reviewText."_changed" );
		$this->assertTrue( $response->getData()->message == 'RecipeReview updated sucessfully!' );


		// verify update was sucessful
		$response = $this->call('GET', '/api/v1/recipe_review/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->review == $reviewText."_changed" );

		// make invalid update
		$response = $this->call('PUT', '/api/v1/recipe_review/'.$recordId, array('score' => 0) );	// score should be between 1 and 5.
		$this->assertFalse( $response->getData()->success );
		$this->assertTrue( $response->getData()->message == 'Error updating RecipeReview!' );


		// now delete the recipe_review
		$response = $this->call('DELETE', '/api/v1/recipe_review/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->message == 'RecipeReview deleted successfully!' );


		// verify delete was sucessful
		$response = $this->call('GET', '/api/v1/recipe_review/'.$recordId );
		$this->assertFalse( $response->getData()->success );
		$this->assertTrue( stripos( $response->getData()->message, 'Could not find RecipeReview with id' ) !== false );
		
	}
}