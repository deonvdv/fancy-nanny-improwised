<?php

class DocumentAPITest extends TestCase {

	public function testDocumentsAPI()
	{
		$crawler = $this->client->request('GET', '/api/v1/documents');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

}