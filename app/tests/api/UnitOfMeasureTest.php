<?php

class UnitOfMeasureAPITest extends TestCase {

	public function testUnitOfMeasuresAPI()
	{
		$crawler = $this->client->request('GET', '/api/v1/units_of_measures');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testStoreGetUpdateAndDeleteUnitOfMeasure() 
	{
		$faker = \Faker\Factory::create();
		
		$name = substr($faker->name,0,50);
		$alias = $name;
		$preferred_alias = substr($faker->name,0,50);
				
		$response = $this->call('POST', '/api/v1/units_of_measure', 
					array( "name"      => $name, 
						"alias" => $alias, 
						"preferred_alias"	=> $preferred_alias ) );
		$recordId = $response->getData()->data->id;

		// Test that record was added
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $recordId != '' );
		$this->assertTrue( $response->getData()->data->name == $name );
		$this->assertTrue( $response->getData()->data->alias == $alias );
		$this->assertTrue( $response->getData()->data->preferred_alias == $preferred_alias );
		$this->assertTrue( $response->getData()->message == 'New UnitsOfMeasure created sucessfully!' );

		// test that location header is set
		$this->assertTrue( stripos( $response->headers, "Location:" ) !== false );
		$this->assertTrue( stripos( $response->headers, "/units_of_measure/".$recordId ) !== false );
		
		// verify insert was sucessful
		$response = $this->call('GET', '/api/v1/units_of_measure/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->name == $name );
		$this->assertTrue( $response->getData()->data->alias == $alias );
		$this->assertTrue( $response->getData()->data->preferred_alias == $preferred_alias );
		
		// edit UnitsOfMeasure
		$response = $this->call('PUT', '/api/v1/units_of_measure/'.$recordId, array('name' => $name."_changed") );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->name == $name."_changed" );
		$this->assertTrue( $response->getData()->message == 'UnitsOfMeasure updated sucessfully!' );

		// verify update was sucessful
		$response = $this->call('GET', '/api/v1/units_of_measure/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->name == $name."_changed" );


		// make invalid update
		$response = $this->call('PUT', '/api/v1/units_of_measure/'.$recordId, array('name' => "") );
		// name is too short
		$this->assertFalse( $response->getData()->success );
		$this->assertTrue( $response->getData()->message == 'Error updating UnitsOfMeasure!' );

		// now delete the UnitsOfMeasure
		$response = $this->call('DELETE', '/api/v1/units_of_measure/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->message == 'UnitsOfMeasure deleted successfully!' );

		// verify delete was sucessful
		$response = $this->call('GET', '/api/v1/units_of_measure/'.$recordId );
		$this->assertFalse( $response->getData()->success );
		$this->assertTrue( stripos( $response->getData()->message, 'Could not find UnitsOfMeasure with id' ) !== false );
		
	}

}