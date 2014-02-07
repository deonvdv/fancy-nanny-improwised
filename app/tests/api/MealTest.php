<?php

class MealAPITest extends TestCase {

	public function testMealsAPI()
	{
		$crawler = $this->client->request('GET', '/api/v1/meals');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

}