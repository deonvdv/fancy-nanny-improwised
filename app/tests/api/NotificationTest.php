<?php

class NotificationAPITest extends TestCase {

	public function testNotificationsAPI()
	{
		$crawler = $this->client->request('GET', '/api/v1/notifications');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

}