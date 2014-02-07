<?php

class MessageAPITest extends TestCase {

	public function tesMessagesAPI()
	{
		$crawler = $this->client->request('GET', '/api/v1/messages');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

}