<?php

class CategoryTableSeeder extends Seeder {

    public function run()
    {
    	$faker = \Faker\Factory::create();
    	$categories = array(
    		'id' => $faker->uuid,
    		'parent_id' => $faker->uuid,
    		'name' => $faker->name,
    	);
    	DB::table('categories')->insert( $categories );
    }
}