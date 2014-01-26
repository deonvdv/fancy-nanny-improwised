<?php

class RecipeTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanCreateRecipe()
	{
		// Get Author
		$user = \Models\User::where('name', '=', 'Deon van der Vyver')->first();

		$recipe = new \Models\Recipe();

		$recipe->name = "Test Recipe";
		$recipe->description = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Impedit, similique, ex, facilis, tempore fugit eum nemo at rerum placeat atque magnam minima dolorum provident ut quis animi pariatur veniam ipsa.";
		$recipe->instructions = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis inventore illo est quam laboriosam veniam esse recusandae placeat error amet. Ea, quae, fuga labore non voluptatibus omnis esse deserunt eum!";
		$recipe->number_of_portions = 4;
		$recipe->preparation_time = "00:15";
		$recipe->cooking_time = "00:15";

		// Assign author
		// $recipe = $user->recipes()->save($recipe);
		$recipe->author()->associate($user);
		
		$recipe->save();

		$this->assertTrue($recipe->id !== '');
		$this->assertTrue($recipe->name == 'Test Recipe');
		$this->assertTrue($recipe->description == 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Impedit, similique, ex, facilis, tempore fugit eum nemo at rerum placeat atque magnam minima dolorum provident ut quis animi pariatur veniam ipsa.');
		$this->assertTrue($recipe->instructions == 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis inventore illo est quam laboriosam veniam esse recusandae placeat error amet. Ea, quae, fuga labore non voluptatibus omnis esse deserunt eum!');
		$this->assertTrue($recipe->number_of_portions == 4);
		$this->assertTrue($recipe->preparation_time == '00:15');
		$this->assertTrue($recipe->cooking_time == '00:15');

		$id = $recipe->id;

		$found = \Models\Recipe::where('id', '=', $id)->first();
		// print_r($found);

		$this->assertTrue($found->id == $id);
		$this->assertTrue($found->name == 'Test Recipe');
		$this->assertTrue($found->description == 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Impedit, similique, ex, facilis, tempore fugit eum nemo at rerum placeat atque magnam minima dolorum provident ut quis animi pariatur veniam ipsa.');
		$this->assertTrue($found->instructions == 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis inventore illo est quam laboriosam veniam esse recusandae placeat error amet. Ea, quae, fuga labore non voluptatibus omnis esse deserunt eum!');
		$this->assertTrue($found->number_of_portions == 4);
		$this->assertTrue($found->preparation_time == '00:15:00');
		$this->assertTrue($found->cooking_time == '00:15:00');
		// $this->assertTrue($this->client->getResponse()->isOk());
	}

}