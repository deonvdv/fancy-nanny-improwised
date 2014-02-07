<?php

class CategoryAPITest extends TestCase {

	public function testCategoriesAPI()
	{
		$crawler = $this->client->request('GET', '/api/v1/categories');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

}