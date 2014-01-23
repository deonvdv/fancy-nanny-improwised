<?php

class TagTableSeeder extends Seeder {

    public function run()
    {
    	$faker = \Faker\Factory::create();
    	$tags = array(
    		'id' => $faker->uuid,
            'household_id' => $faker->uuid,
    		'user_id' => $faker->uuid,
    		'name' => $faker->name,
            'color' => $faker->colorName,
    	);
    	DB::table('tags')->insert( $tags );
    }
}