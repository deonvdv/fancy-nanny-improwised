<?php

class DocumentTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanCreateDocumentSaveRetrieveAndDelete()
	{

    	$faker = \Faker\Factory::create();
		
		// Get the owner
		$user = \Models\User::where('name', '=', 'Deon van der Vyver')->first();

		// Get household
		$household = \Models\Household::where('name','like','%household')->first();

		//associate household
		$user->household()->associate($household);

		// Create new Document
		$fileName = $faker->word.'.'.$faker->fileExtension;

		$doc = new \Models\Document();
        $doc->name = ucwords($faker->bs);
        $doc->file_name = $fileName;
        $doc->cdn_url = $faker->url.$faker->uuid."/".$fileName;
        // $doc->household_id = $curhousehold->id;
        $doc->private = $faker->boolean;

		// set Owner
        $doc->setOwner( $user );
		
		$id = $doc->id;

		//get Document from database
		$found = \Models\Document::where('id', '=', $id)->with('owner','household')->firstOrFail();
		// print_r($found);
		// echo "\nFound Id: " . $found->id . "\n";
		
		$this->assertTrue($found->id == $id);

		// Test Document
		$this->assertTrue($found->id == $doc->id);
		$this->assertTrue($found->name == $doc->name);
		$this->assertTrue($found->file_name == $doc->file_name);
		$this->assertTrue($found->cdn_url == $doc->cdn_url);
		$this->assertTrue($found->private == $doc->private);
		$this->assertTrue($found->owner->id == $user->id);
		$this->assertTrue($found->household->id == $user->household->id);

		// Delete
		$this->assertTrue( $found->delete() );
	}

}