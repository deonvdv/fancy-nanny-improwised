<?php

use \Models;

class RecipeModelTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanCreateRecipeSaveRetrieveAndDelete()
	{
		// echo "\nRecipe Test...\n";
		
    	$faker = \Faker\Factory::create();
		// $this->migrate();
		// $this->seed();

		// Get Author
		$user = parent::createFakeUserWithFakeHousehold();

		// Get the category
		$cat = \Models\Category::where('name', '=', 'Ethnic')->first();

		// Create recipe
    	$recipe = parent::createFakeRecipe();

		// Assign author
		$recipe->setAuthor( $user );

		// assign the category
		$recipe->setCategory( $cat );

		// Do RecipeIngredients
		$recipe_ingredient1 = new \Models\RecipeIngredient();
		$recipe_ingredient1->unit_of_measure()->associate( \Models\UnitOfMeasure::where('name', 'like', '%spoon%')->first() );
		$recipe_ingredient1->ingredient()->associate( \Models\Ingredient::where('name', 'like', 'flour')->first() );
		$recipe_ingredient1->quantity = 2.5;
		$recipe->addRecipeIngredient( $recipe_ingredient1 );

		$recipe_ingredient2 = new \Models\RecipeIngredient();
		$recipe_ingredient2->unit_of_measure()->associate( \Models\UnitOfMeasure::where('name', 'like', 'teaspoon')->first() );
		$recipe_ingredient2->ingredient()->associate( \Models\Ingredient::where('name', 'like', 'salt')->first() );
		$recipe_ingredient2->quantity = 1;
		$recipe->addRecipeIngredient( $recipe_ingredient2 );

		// Do Morp Relationships
		
		// // Add some pictures
		for($x = 0;$x < 2;$x++) {
			// echo "Here...\n";

			$pic = parent::createFakePicture( $user );
			$recipe->addPicture( $pic );
		}

		// Add Tags
		$tag1 = parent::createFakeTag( $user );
		$recipe->addTag( $tag1 );

		$tag2 = parent::createFakeTag( $user );
		$recipe->addTag( $tag2 );


		// Test		
		$id = $recipe->id;

		$found = \Models\Recipe::with( array('category','tags','recipe_ingredients') )->where('id', '=', $id)->firstOrFail();
		// print_r($found);

		$this->assertTrue($found->id == $id);

		// Test Author
		$this->assertTrue($found->author_id == $user->id);
		$this->assertTrue($found->author->id == $user->id);
		$this->assertTrue($found->author->name == $user->name);
		$this->assertTrue($found->author->email == $user->email);

		// test recipe inredients
		// var_dump( $found->recipe_ingredients->toArray() );
		$this->assertTrue( count( $found->recipe_ingredients ) == 2 );
		$this->assertTrue( $found->recipe_ingredients->contains( $recipe_ingredient1->id ) );
		$this->assertTrue( $found->recipe_ingredients->contains( $recipe_ingredient2->id ) );

		// test pictures
		// var_dump( $found->pictures->toArray() );
		$this->assertTrue( count( $found->pictures ) == 2 );

		// Test Category
		$this->assertTrue($found->category_id == $cat->id);
		$this->assertTrue($found->category->id == $cat->id);
		$this->assertTrue($found->category->name == $cat->name);

		//Test Tags
		$this->assertTrue(count($found->tags) == 2);

		$this->assertTrue($found->name == $recipe->name);
		$this->assertTrue($found->description == $recipe->description);
		$this->assertTrue($found->instructions == $recipe->instructions);
		$this->assertTrue($found->number_of_portions == $recipe->number_of_portions);
		$this->assertTrue($found->preparation_time == $recipe->preparation_time);
		$this->assertTrue($found->cooking_time == $recipe->cooking_time);

		// Delete
		$this->assertTrue($found->delete());
	}

	public function testRecipeValidation() {
    	$faker = \Faker\Factory::create();

    	$user = parent::createFakeUserWithFakeHousehold();

		$recipe = new \Models\Recipe();
       
       	$this->assertFalse( $recipe->validate() );

       	// print_r($recipe->errors()->first("name"));
       	// print_r($recipe->errors()->first("description"));
       	// print_r($recipe->errors()->first("instructions"));

       	// print_r($recipe->errors()->first("preparation_time"));
       	// print_r($recipe->errors()->first("cooking_time"));
       	// print_r($recipe->errors()->first("author_id"));

		$this->assertTrue( $recipe->errors()->first("name") == "The name field is required." );
		$this->assertTrue( $recipe->errors()->first("description") == "The description field is required." );
		$this->assertTrue( $recipe->errors()->first("instructions") == "The instructions field is required." );
		$this->assertTrue( $recipe->errors()->first("preparation_time") == "The preparation time field is required." );
		$this->assertTrue( $recipe->errors()->first("cooking_time") == "The cooking time field is required." );
		$this->assertTrue( $recipe->errors()->first("author_id") == "The author id field is required." );
		
		$recipe->name = $faker->name;
		$recipe->description = $faker->text;
		$recipe->instructions = $faker->text;
		$recipe->number_of_portions = $faker->randomDigit;
		$recipe->preparation_time = $faker->time;
		$recipe->cooking_time = $faker->time;
		$recipe->setAuthor($user);

		$this->assertTrue( $recipe->validate() );
		unset($recipe);
	}

	public function testInvalidRecipeCannotSave() {

		$model = new \Models\Recipe();
		$model->quantity = 5;

		$this->assertFalse( $model->save() );
	}
}