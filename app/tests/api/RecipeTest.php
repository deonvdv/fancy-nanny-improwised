<?php

class RecipeAPITest extends TestCase {

	public function testRecipesAPI()
	{
		$crawler = $this->client->request('GET', '/api/v1/recipes');
		$this->assertTrue($this->client->getResponse()->isOk());
	}
}