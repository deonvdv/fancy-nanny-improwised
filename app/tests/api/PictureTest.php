<?php

class PictureAPITest extends TestCase {

	public function testPicturesAPI()
	{
		$crawler = $this->client->request('GET', '/api/v1/pictures');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testStoreGetUpdateAndDeletePicture() {
		$faker = \Faker\Factory::create();

		$user = parent::createFakeUser();
		$pictureName = ucwords($faker->bs);
		$file_name =  $faker->word.'.'.$faker->fileExtension;
		$cdn_url = $faker->word;

		$response = $this->call('POST', '/api/v1/picture', 
					array('owner_id' => $user->id,
						"name"      => $pictureName, 
						"file_name" => $file_name, 
						"cdn_url"	=> $cdn_url,  
						"imageable_id" => $user->id,
						"imageable_type" => '\Models\User' ) );
		$recordId = $response->getData()->data->id;

		// Test that record was added
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $recordId != '' );
		$this->assertTrue( $response->getData()->data->name == $pictureName );
		$this->assertTrue( $response->getData()->data->file_name == $file_name );
		$this->assertTrue( $response->getData()->data->cdn_url == $cdn_url );
		$this->assertTrue( $response->getData()->data->imageable_id == $user->id );
		$this->assertTrue( $response->getData()->data->owner_id == $user->id );
		$this->assertTrue( $response->getData()->message == 'New Picture created sucessfully!' );


		// test that location header is set
		$this->assertTrue( stripos( $response->headers, "Location:" ) !== false );
		$this->assertTrue( stripos( $response->headers, "/picture/".$recordId ) !== false );
		

		// verify insert was sucessful
		$response = $this->call('GET', '/api/v1/picture/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->name == $pictureName );
		$this->assertTrue( $response->getData()->data->file_name == $file_name );
		$this->assertTrue( $response->getData()->data->cdn_url == $cdn_url );
		$this->assertTrue( $response->getData()->data->imageable_id == $user->id );
		$this->assertTrue( $response->getData()->data->owner_id == $user->id );

		// edit picture
		$response = $this->call('PUT', '/api/v1/picture/'.$recordId, array('name' => $pictureName."_changed") );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->name == $pictureName."_changed" );
		$this->assertTrue( $response->getData()->message == 'Picture updated sucessfully!' );


		// verify update was sucessful
		$response = $this->call('GET', '/api/v1/picture/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->data->id == $recordId );
		$this->assertTrue( $response->getData()->data->name == $pictureName."_changed" );


		// make invalid update
		$response = $this->call('PUT', '/api/v1/picture/'.$recordId, array('name' => "x") );	// name is too short
		$this->assertFalse( $response->getData()->success );
		$this->assertTrue( $response->getData()->message == 'Error updating Picture!' );


		// now delete the picture
		$response = $this->call('DELETE', '/api/v1/picture/'.$recordId );
		$this->assertTrue( $response->getData()->success );
		$this->assertTrue( $response->getData()->message == 'Picture deleted successfully!' );


		// verify delete was sucessful
		$response = $this->call('GET', '/api/v1/picture/'.$recordId );
		$this->assertFalse( $response->getData()->success );
		$this->assertTrue( stripos( $response->getData()->message, 'Could not find Picture with id' ) !== false );
		
	}
}