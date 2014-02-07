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
            exit('I just stopped you getting fired!! Deon');
        }

		Eloquent::unguard();

		$tables = [
	        'categories',
	        'documents',
	        'events',
	        'evnets_attendees',
	        'households',
	        'household_services',
	        'ingredients',
	        'invoices',
	        'meals',
	        'meals_recipes',
	        'messages',
	        'notifications',
	        'pictures',
	        'products',
	        'recipes',
	        'recipe_ingredients',
	        'recipe_reviews',
	        'tags',
	        'todos',
	        'units_of_measure',
	        'users',
	    ];

	    foreach ($tables as $table) {
	    	if(Schema::hasTable($table)){
	    		DB::table($table)->truncate();
	    	}	    	       
	    }

		$this->call('HouseholdTableSeeder');
		$this->call('UserTableSeeder');
	    $this->call('MessageTableSeeder');
	    $this->call('PictureTableSeeder');
	    $this->call('IngredientTableSeeder');
	    $this->call('UnitOfMeasureTableSeeder');
	    $this->call('TagTableSeeder');
	    $this->call('CategoryTableSeeder');
	    $this->call('DocumentTableSeeder');
	    $this->call('EventTableSeeder');
	    $this->call('NotificationTableSeeder');
	    $this->call('RecipeTableSeeder');
	    $this->call('TodoTableSeeder');
		$this->call('MealTableSeeder');

	}

}