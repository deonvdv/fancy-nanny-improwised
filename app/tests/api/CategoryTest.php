<?php

class CategoryAPITest extends TestCase {

	public function testCategoriesAPI()
	{
		$crawler = $this->client->request('GET', '/api/v1/categories');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testStoreGetUpdateAndDeleteCategory() {
		$faker = \Faker\Factory::create();

		$categoryName = $faker->bs;

		$response = $this->call('POST', '/api/v1/category', array('name' => $categoryName) );
		$recordId = $response->getData()->data->id;

		// Test that record was added
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $recordId != '' );
		$this->assertTrue( $response->getData()->data->name == $categoryName );
		$this->assertTrue( $response->getData()->message == 'New Category created sucessfully!' );


		// test that location header is set
		$this->assertTrue( stripos( $response->headers, "Location:" ) !== false );
		$this->assertTrue( stripos( $response->headers, "/category/".$recordId ) !== false );
		

		// verify insert was sucessful
		$response = $this->call('GET', '/api/v1/category/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->name == $categoryName );


		// edit category
		$response = $this->call('PUT', '/api/v1/category/'.$recordId, array('name' => $categoryName."_changed") );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->name == $categoryName."_changed" );
		$this->assertTrue( $response->getData()->message == 'Category updated sucessfully!' );


		// verify update was sucessful
		$response = $this->call('GET', '/api/v1/category/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->name == $categoryName."_changed" );


		// make invalid update
		$response = $this->call('PUT', '/api/v1/category/'.$recordId, array('name' => "x") );	// name is too short
		$this->assertFalse( $response->getData()->success );
		$this->assertTrue( $response->getData()->message == 'Error updating Category!' );


		// now delete the category
		$response = $this->call('DELETE', '/api/v1/category/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->message == 'Category deleted successfully!' );


		// verify delete was sucessful
		$response = $this->call('GET', '/api/v1/category/'.$recordId );
		$this->assertFalse( $response->getData()->success );
		$this->assertTrue( stripos( $response->getData()->message, 'Could not find Category with id' ) !== false );
		 

	}
}