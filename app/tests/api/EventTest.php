<?php

class EventAPITest extends TestCase {

	public function testEventsAPI()
	{
		$crawler = $this->client->request('GET', '/api/v1/events');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

}