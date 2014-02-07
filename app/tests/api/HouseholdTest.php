<?php

class HouseholdAPITest extends TestCase {

	public function testHouseholdsAPI()
	{
		$crawler = $this->client->request('GET', '/api/v1/households');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

}