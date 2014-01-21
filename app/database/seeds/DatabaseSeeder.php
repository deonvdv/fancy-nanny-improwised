<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		if (App::environment() === 'production') {
            exit('I just stopped you getting fired. Love Deon');
        }

		Eloquent::unguard();

		$tables = [
	        'categories',
	        'documents',
	        'events',
	        'households',
	        'household_services',
	        'ingredients',
	        'invoices',
	        'meals',
	        'meals_recipes',
	        'meals_tags',
	        'messages',
	        'notifications',
	        'pictures',
	        'products',
	        'recipes',
	        'recipes_categories',
	        'recipes_tags',
	        'recipe_ingredients',
	        'recipe_reviews',
	        'tags',
	        'todos',
	        'unit_measures',
	        'users',
	    ];

	    foreach ($tables as $table) {
	        DB::table($table)->truncate();
	    }

		$this->call('UserTableSeeder');
		$this->call('HouseholdTableSeeder');
	}

}