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
		$newCategory->parent_id = $cat->id;
		$newCategory->save();

		$id = $newCategory->id;

		//get Category from database
		$found = \Models\Category::where('id', '=', $id)->firstOrFail();
		
		$this->assertTrue($found->id == $id);

		// Test Category
		$this->assertTrue($found->id == $newCategory->id);
		$this->assertTrue($found->parent_id == $newCategory->parent_id);
		$this->assertTrue($found->name == $newCategory->name);
	}

}