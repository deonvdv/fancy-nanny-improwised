<?php

class CategoryTableSeeder extends Seeder {

    public function run()
    {
    	$faker = \Faker\Factory::create();

        for ($i = 0; $i < 100; $i++) {
        	$category = array(
        		'id' => $faker->uuid,
        		'parent_id' => null,
        		'name' => ucfirst($faker->unique()->word),
        	);
            \Models\Category::create( $category );
        }
    	
    }
}