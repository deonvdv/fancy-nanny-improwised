<?php

use \Models;

class RecipeReviewModelTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanCreateRecipeReviewSaveRetrieveAndDelete()
	{
		
    	$faker = \Faker\Factory::create();
		
		// Get the recipe
		$recipe = parent::createFakeRecipe();

		//Get the user
		$user = parent::createFakeUser();

		$newrr = new \Models\RecipeReview();

		// Set user
		$newrr->setUser( $user );

		// Set recipe
		$newrr->setRecipe( $recipe );
		
		$newrr->score = 3;
		$newrr->review = 'nice recipe';
		$this->assertTrue( $newrr->validate() );
		
		$newrr->save();

		$id = $newrr->id;

		//get RecipeReview from database
		$found = \Models\RecipeReview::where('id', '=', $id)->firstOrFail();
		// print_r($found);
		// echo "\nFound Id: " . $found->id . "\n";

		$this->assertTrue($found->id == $id);

		// Test RecipeReview
		$this->assertTrue($found->id == $newrr->id);
		$this->assertTrue($found->recipe->id == $newrr->recipe_id);
		$this->assertTrue($found->user->id == $newrr->user_id);
		$this->assertTrue($found->score == $newrr->score);
		$this->assertTrue($found->review == $newrr->review);

		// Delete
		$this->assertTrue( $found->delete() );

		unset($newrr);
	}

	 public function testRecipeReviewValidation() {
     	$faker = \Faker\Factory::create();

     	$user = parent::createFakeUser();
		$recipe = parent::createFakeRecipe();     	

		$newrr = new \Models\RecipeReview();
		$newrr->review = "aa";

	 	$this->assertFalse( $newrr->validate() );
		
		$this->assertTrue( $newrr->errors()->first("recipe_id") == "The recipe id field is required." );
		$this->assertTrue( $newrr->errors()->first("user_id") == "The user id field is required." );
		$this->assertTrue( $newrr->errors()->first("score") == "The score field is required." );

		$newrr->recipe_id = $faker->uuid;
		$newrr->user_id   = $faker->uuid;
		$newrr->score = 0;

		$this->assertFalse( $newrr->validate() );

		$this->assertTrue( $newrr->errors()->first("recipe_id") == "The selected recipe id is invalid." );
		$this->assertTrue( $newrr->errors()->first("user_id") == "The selected user id is invalid." );
		$this->assertTrue( $newrr->errors()->first("score") == "The score must be between  1 and 5." );

		$newrr->setUser( $user );
		$newrr->setRecipe( $recipe );
		$newrr->score = 5;

		echo( $newrr->errors()->first("recipe_id") );
		echo( $newrr->errors()->first("user_id") );
		echo( $newrr->errors()->first("score") );

		$this->assertTrue( $newrr->validate() );
		
		unset($newrr);
	 }

	public function testInvalidCategoryCannotSave() {

		$model = new \Models\RecipeReview();
		$model->score = "0";

		//Try to save data
		$this->assertFalse($model->save());		
	}


}