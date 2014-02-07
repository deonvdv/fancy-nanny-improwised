<?php

class PictureAPITest extends TestCase {

	public function testPicturesAPI()
	{
		$crawler = $this->client->request('GET', '/api/v1/pictures');
		$this->assertTrue($this->client->getResponse()->isOk());
	}
}