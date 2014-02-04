<?php

class RecipeTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanCreateRecipeSaveRetrieveAndDelete()
	{

    	$faker = \Faker\Factory::create();
		// $this->migrate();
		// $this->seed();

		// Get Author
		$user = \Models\User::where('name', '=', 'Deon van der Vyver')->first();

		// Get the category
		$cat = \Models\Category::where('name', '=', 'Ethnic')->first();

		// Get household
		$household = \Models\Household::where('name','like','%household')->first();

		$recipe = new \Models\Recipe();

		$recipe->name = "Test Recipe";
		$recipe->description = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Impedit, similique, ex, facilis, tempore fugit eum nemo at rerum placeat atque magnam minima dolorum provident ut quis animi pariatur veniam ipsa.";
		$recipe->instructions = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis inventore illo est quam laboriosam veniam esse recusandae placeat error amet. Ea, quae, fuga labore non voluptatibus omnis esse deserunt eum!";
		$recipe->number_of_portions = 4;
		$recipe->preparation_time = "00:15";
		$recipe->cooking_time = "00:15";

		// Assign author
		$recipe->setAuthor( $user );

		// assign the category
		$recipe->setCategory( $cat );

		// Do RecipeIngredients
		$recipe_ingredient1 = new \Models\RecipeIngredient();
		$recipe_ingredient1->unit_of_measure()->associate( \Models\UnitOfMeasure::where('name', 'like', 'cup')->first() );
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

	    	$tmp = array(
	            'name' => $faker->bs,
	            'file_name' => $faker->name . "." . $faker->fileExtension,
	            'cdn_url' => $faker->url,
	        );

			$pic = new \Models\Picture( $tmp );
			// print_r($pic);
			
			// Add the Picture Owner
			$pic->owner()->associate($user); 	// I fixed the association (belongsTo)

			$recipe->addPicture( $pic );
		}

		// Add Tags
		$tag1 = new \Models\Tag( array ('name' => 'tag 3',
										'household_id' => $household->id,
										'user_id' => $user->id,
										'color' => substr($faker->colorName,0,7)));
		$recipe->addTag( $tag1 );

		$tag2 = new \Models\Tag( array ('name' => 'tag 4',
										'household_id' => $household->id,
										'user_id' => $user->id,
										'color' => substr($faker->colorName,0,7) ) );
		$recipe->addTag( $tag2 );



		// Test		
		$this->assertTrue($recipe->id !== '');
		$this->assertTrue($recipe->author_id == $user->id);
		$this->assertTrue($recipe->category_id == $cat->id);
		$this->assertTrue($recipe->name == 'Test Recipe');
		$this->assertTrue($recipe->description == 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Impedit, similique, ex, facilis, tempore fugit eum nemo at rerum placeat atque magnam minima dolorum provident ut quis animi pariatur veniam ipsa.');
		$this->assertTrue($recipe->instructions == 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis inventore illo est quam laboriosam veniam esse recusandae placeat error amet. Ea, quae, fuga labore non voluptatibus omnis esse deserunt eum!');
		$this->assertTrue($recipe->number_of_portions == 4);
		$this->assertTrue($recipe->preparation_time == '00:15');
		$this->assertTrue($recipe->cooking_time == '00:15');

		$id = $recipe->id;

		$found = \Models\Recipe::with( array('category','tags','recipe_ingredients') )->where('id', '=', $id)->firstOrFail();
		print_r($found);

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

		$this->assertTrue($found->name == 'Test Recipe');
		$this->assertTrue($found->description == 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Impedit, similique, ex, facilis, tempore fugit eum nemo at rerum placeat atque magnam minima dolorum provident ut quis animi pariatur veniam ipsa.');
		$this->assertTrue($found->instructions == 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis inventore illo est quam laboriosam veniam esse recusandae placeat error amet. Ea, quae, fuga labore non voluptatibus omnis esse deserunt eum!');
		$this->assertTrue($found->number_of_portions == 4);
		$this->assertTrue($found->preparation_time == '00:15:00');
		$this->assertTrue($found->cooking_time == '00:15:00');
		// $this->assertTrue($this->client->getResponse()->isOk());

		// Delete
		$this->assertTrue($found->delete());
	}

}