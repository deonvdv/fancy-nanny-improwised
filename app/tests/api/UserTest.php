<?php

class UserAPITest extends TestCase {

    public function testUsersAPI()
    {
        $crawler = $this->client->request('GET', '/api/v1/users');
        $this->assertTrue($this->client->getResponse()->isOk());
    }
}