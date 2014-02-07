<?php

class TagAPITest extends TestCase {

	public function testTagsAPI()
	{
		$crawler = $this->client->request('GET', '/api/v1/tags');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

}