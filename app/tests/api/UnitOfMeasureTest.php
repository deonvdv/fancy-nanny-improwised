<?php

class UnitOfMeasureAPITest extends TestCase {

	public function testUnitOfMeasuresAPI()
	{
		$crawler = $this->client->request('GET', '/api/v1/units_of_measures');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

}