<?php

class RecipeIngredientAPITest extends TestCase {

	public function testRecipeIngredientsAPI()
	{
		$crawler = $this->client->request('GET', '/api/v1/recipe_ingredients');
		$this->assertTrue($this->client->getResponse()->isOk());
	}
}