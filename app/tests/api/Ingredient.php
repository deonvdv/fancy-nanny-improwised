<?php

class IngredientAPITest extends TestCase {

	public function testIngredientsAPI()
	{
		$crawler = $this->client->request('GET', '/api/v1/ingredients');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

}