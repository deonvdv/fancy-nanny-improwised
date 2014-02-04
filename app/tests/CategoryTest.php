<?php

class CategoryTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanCreateCategorySaveAndRetrieve()
	{

    	$faker = \Faker\Factory::create();
		
		// Get the category
		$cat = \Models\Category::where('name', '=', 'Ethnic')->first();

		$newCategory = new \Models\Category();

		$newCategory->name = "Test Category";
		
		// assign category parentId
		// $newCategory->parent_id = $cat->id;
		$newCategory->addParent( $cat );
		
		$newCategory->save();

		$id = $newCategory->id;

		//get Category from database
		$found = \Models\Category::where('id', '=', $id)->with('parent')->firstOrFail();
		// print_r($found);
		// echo "\nFound Id: " . $found->id . "\n";
		
		$this->assertTrue($found->id == $id);

		// Test Category
		$this->assertTrue($found->id == $newCategory->id);
		$this->assertTrue($found->parent->id == $cat->id);
		$this->assertTrue($found->name == $newCategory->name);

		// Delete
		$this->assertTrue( $found->delete() );
	}

}