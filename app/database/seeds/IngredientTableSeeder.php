<?php

class IngredientTableSeeder extends Seeder {

    public function run()
    {
    	$faker = \Faker\Factory::create();
    	$ingredient = array(
    		'id' => $faker->uuid,
    		'name' => $faker->name,
    	);
    	DB::table('ingredients')->insert( $ingredient );
    }
}