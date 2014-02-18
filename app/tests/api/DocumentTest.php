<?php

class DocumentAPITest extends TestCase {

	public function testDocumentsAPI()
	{
		$crawler = $this->client->request('GET', '/api/v1/documents');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testStoreGetUpdateAndDeleteDocument() {
		$faker = \Faker\Factory::create();

		$user = parent::createFakeUser();
		$documentName = ucwords($faker->bs);
		$file_name =  $faker->word.'.'.$faker->fileExtension;
		$cdn_url = $faker->word;

		$response = $this->call('POST', '/api/v1/document', 
					array('owner_id' => $user->id,
						"name"      => $documentName, 
						"file_name" => $file_name, 
						"cdn_url"	=> $cdn_url,  
						"private"   => false ) );
		$recordId = $response->getData()->data->id;

		// Test that record was added
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $recordId != '' );
		$this->assertTrue( $response->getData()->data->name == $documentName );
		$this->assertTrue( $response->getData()->data->file_name == $file_name );
		$this->assertTrue( $response->getData()->data->cdn_url == $cdn_url );
		$this->assertTrue( $response->getData()->data->private == false );
		$this->assertTrue( $response->getData()->data->owner_id == $user->id );
		$this->assertTrue( $response->getData()->message == 'New Document created sucessfully!' );


		// test that location header is set
		$this->assertTrue( stripos( $response->headers, "Location:" ) !== false );
		$this->assertTrue( stripos( $response->headers, "/document/".$recordId ) !== false );
		

		// verify insert was sucessful
		$response = $this->call('GET', '/api/v1/document/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->name == $documentName );
		$this->assertTrue( $response->getData()->data->file_name == $file_name );
		$this->assertTrue( $response->getData()->data->cdn_url == $cdn_url );
		$this->assertTrue( $response->getData()->data->private == false );
		$this->assertTrue( $response->getData()->data->owner_id == $user->id );

		// edit document
		$response = $this->call('PUT', '/api/v1/document/'.$recordId, array('name' => $documentName."_changed") );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->name == $documentName."_changed" );
		$this->assertTrue( $response->getData()->message == 'Document updated sucessfully!' );


		// verify update was sucessful
		$response = $this->call('GET', '/api/v1/document/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->name == $documentName."_changed" );


		// make invalid update
		$response = $this->call('PUT', '/api/v1/document/'.$recordId, array('name' => "x") );	// name is too short
		$this->assertFalse( $response->getData()->success );
		$this->assertTrue( $response->getData()->message == 'Error updating Document!' );


		// now delete the document
		$response = $this->call('DELETE', '/api/v1/document/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->message == 'Document deleted successfully!' );


		// verify delete was sucessful
		$response = $this->call('GET', '/api/v1/document/'.$recordId );
		$this->assertFalse( $response->getData()->success );
		$this->assertTrue( stripos( $response->getData()->message, 'Could not find Document with id' ) !== false );
		
	}
}