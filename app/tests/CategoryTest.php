<?php

class CategoryTest extends TestCase {

	// public function setUp() {
 //        // parent::setUp();

 //        // Artisan::call('migrate');
 //        // Artisan::call('db:seed');
 //        // Mail::pretend(true);
 //    }

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCanCreateCategorySaveAndRetrieve()
	{

    	$faker = \Faker\Factory::create();
		// $this->migrate();
		// $this->seed();

		// Get the category
		$cat = \Models\Category::where('name', '=', 'Ethnic')->first();

		$newCategory = new \Models\Category();

		$newCategory->name = "Test Category";

		// assign category parentId
		$newCategory->parent_id = $cat->id;

		$newCategory->save();

		$id = $newCategory->id;

		$found = \Models\Category::where('id', '=', $id)->firstOrFail();
		// print_r($found);

		$this->assertTrue($found->id == $id);

		// Test Category
		$this->assertTrue($found->id == $newCategory->id);
		$this->assertTrue($found->parent_id == $newCategory->parent_id);
		$this->assertTrue($found->name == $newCategory->name);
	}

}