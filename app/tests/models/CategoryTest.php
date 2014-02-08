<?php

use \Models;

class CategoryModelTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanCreateCategorySaveRetrieveAndDelete()
	{
		// echo "\nCategory Test...\n";

    	$faker = \Faker\Factory::create();
		
		// Get the category
		$cat = \Models\Category::where('name', '=', 'Ethnic')->first();

		$newCategory = new \Models\Category();

		$newCategory->name = $faker->bs;
		
		// assign category parentId
		// $newCategory->parent_id = $cat->id;
		$newCategory->setParent( $cat );
		
		$newCategory->save();

		$id = $newCategory->id;

		//get Category from database
		$found = \Models\Category::where('id', '=', $id)->firstOrFail();
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

	public function testCategoryValidation() {
		$newCategory = new \Models\Category();
		$newCategory->name = "aa";

		$this->assertFalse( $newCategory->validate() );
		echo( $newCategory->errors()->first("name") );
		$this->assertTrue( $newCategory->errors()->first("name") == "The name must be at least 3 characters." );

	}

}