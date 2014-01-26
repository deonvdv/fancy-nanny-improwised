<?php

class RecipeTest extends TestCase {

	// public function setUp() {
 //        // parent::setUp();

 //        // Artisan::call('migrate');
 //        // Artisan::call('db:seed');
 //        // Mail::pretend(true);
 //    }

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanCreateRecipeSaveAndRetrieve()
	{

    	$faker = \Faker\Factory::create();
		// $this->migrate();
		// $this->seed();

		// Get Author
		$user = \Models\User::where('name', '=', 'Deon van der Vyver')->first();

		// Get the category
		$cat = \Models\Category::where('name', '=', 'Ethnic')->first();

		$recipe = new \Models\Recipe();

		$recipe->name = "Test Recipe";
		$recipe->description = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Impedit, similique, ex, facilis, tempore fugit eum nemo at rerum placeat atque magnam minima dolorum provident ut quis animi pariatur veniam ipsa.";
		$recipe->instructions = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis inventore illo est quam laboriosam veniam esse recusandae placeat error amet. Ea, quae, fuga labore non voluptatibus omnis esse deserunt eum!";
		$recipe->number_of_portions = 4;
		$recipe->preparation_time = "00:15";
		$recipe->cooking_time = "00:15";

		// Assign author
		// $recipe = $user->recipes()->save($recipe);
		$recipe->author()->associate($user);	//  (belongsTo)

		// assign the category
		$recipe->category()->associate($cat);	//  (belongsTo)

		// Do RecipeIngredients
		// $ingredient = new \Models\RecipeIngredient();
		// $ingredient->quantity = 5;
		// $ingredient->unit

		$recipe->save();

		// Do Morp Relationships
		
		// // Add some pictures
		$pic = \Models\Picture::take(2)->get();
		$recipe->pictures()->save($pic[0]);
		$recipe->pictures()->save($pic[1]);

		// // Note:: Recipe *MUST* be saved before attaching the Pictures
		// for($x = 0;$x < 2;$x++) {
		// 	echo "Here...\n";

	 //    	$tmp = array(
	 //            'name' => $faker->bs,
	 //            'file_name' => $faker->name . "." . $faker->fileExtension,
	 //            'cdn_url' => $faker->url,
	 //        );

	 //        // print_r($tmp);
		// 	// $pic = new \Models\Picture( $tmp );
		// 	$pic = new \Models\Picture( $tmp );
		// 	print_r($pic);
			
		// 	// Add the Picture Owner
		// 	// $pic->user_id = $user->id;	// Cannot attach it with Eloquent since it overrides the Recipe Pic
		// 	// $pic->owner()->associate($user); 	// I fixed the association (belongsTo)
		// 	// $recipe->pictures()->save($pic);

		// 	// $pic->save();
		// 	// print_r($pic);

		// 	// $pic = \Models\Picture::create( $tmp );
		// 	// $pic->owner()->associate($user); 	// I fixed the association (belongsTo)
		// 	// print_r($pic);

		// 	// $pic->save();

		// 	// print_r($pic);
		// 	// $recipe->pictures()->save($pic);
		// }

		// Add Tags
		// Note:: Recipe *MUST* be saved before attaching the Tags
		// 		  Tags saves to the DB using the $recipe->tags()->save($tag1) method
		// 		  No need to save the Tags first
		$tag1 = new \Models\Tag( array ('name' => 'tag 3') );
		$recipe->tags()->save($tag1);

		$tag2 = new \Models\Tag( array ('name' => 'tag 4') );
		$recipe->tags()->save($tag2);

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

		$found = \Models\Recipe::with( array('category','tags') )->where('id', '=', $id)->firstOrFail();
		// print_r($found);

		$this->assertTrue($found->id == $id);

		// Test Author
		$this->assertTrue($found->author_id == $user->id);
		$this->assertTrue($found->author->id == $user->id);
		$this->assertTrue($found->author->name == $user->name);
		$this->assertTrue($found->author->email == $user->email);

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
	}

}