<?php

use \Models;

class DocumentModelTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanCreateDocumentSaveRetrieveAndDelete()
	{
		// echo "\nDocument Test...\n";
		
    	$faker = \Faker\Factory::create();
		
		// Get the owner
		// $user = \Models\User::with('household')->where('name', '=', 'Deon van der Vyver')->first();
		$user = parent::createFakeUserWithFakeHousehold();
		// print_r( $user );
		// return;

		// Create new Document
		$fileName = $faker->word.'.'.$faker->fileExtension;

		$doc = new \Models\Document();
        $doc->name = ucwords($faker->bs);
        $doc->file_name = $fileName;
        $doc->cdn_url = $faker->url.$faker->uuid."/".$fileName;
        $doc->private = $faker->boolean;

		// set Owner
        $doc->setOwner( $user );

        // Add Tags
		$tag1 = parent::createFakeTag( $user );
		$doc->addTag( $tag1 );

		$tag2 = parent::createFakeTag( $user );
		$doc->addTag( $tag2 );
		
		$id = $doc->id;

		//get Document from database
		$found = \Models\Document::with('tags')->where('id', '=', $id)->firstOrFail();
		// print_r($found);
		// echo "\nFound Id: " . $found->id . "\n";
		
		$this->assertTrue($found->id == $id);

		// Test Document
		$this->assertTrue($found->id == $doc->id);
		$this->assertTrue($found->owner->id == $user->id);
		$this->assertTrue($found->name == $doc->name);
		$this->assertTrue($found->file_name == $doc->file_name);
		$this->assertTrue($found->cdn_url == $doc->cdn_url);
		$this->assertTrue($found->private == $doc->private);

		//Test Tags
		$this->assertTrue(count($found->tags) == 2);

		// echo "\nDocument Test: User Id: " . $user->id;
		// echo "\nDocument Test: User Household Id: " . $user->household->id . "\n";
	
		// Delete
		$this->assertTrue( $found->delete() );
		
	}

	public function testDocumentValidation() {
    	$faker = \Faker\Factory::create();

		$user = parent::createFakeUserWithFakeHousehold();

		$doc = new \Models\Document();
        $doc->name = "aa";
        $doc->file_name = "aa";

		$this->assertFalse( $doc->validate() );
		//var_dump( $doc->validate() );
		// var_dump( $doc->errors() );
		// print_r( $doc->errors()->first("name") );
		// print_r( $doc->errors()->first("file_name") );
		// print_r( $doc->errors()->first("household_id") );
		// print_r( $doc->errors()->first("owner_id") );

		$this->assertTrue( $doc->errors()->first("name") == "The name must be at least 3 characters." );
		$this->assertTrue( $doc->errors()->first("file_name") == "The file name must be at least 3 characters." );
		$this->assertTrue( $doc->errors()->first("owner_id") == "The owner id field is required." );

		$doc->name = $faker->text(100);
		$doc->file_name = $faker->text(100);
		$doc->cdn_url = $faker->url.$faker->uuid."/".$doc->fileName;
		$doc->owner_id = $user->id;
		$doc->household_id = $user->household_id;
		
        $this->assertTrue( $doc->validate() );
        unset($doc);
	}

	public function testInvalidDocumentCannotSave() {

		$model = new \Models\Document();
		$model->name = "aa";

		$this->assertFalse( $model->save() );
	}


}