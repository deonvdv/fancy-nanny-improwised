<?php

class MealTableSeeder extends Seeder {

    public function run()
    {
    	$faker = \Faker\Factory::create();
 		$meals = array(
    		'id' => $faker->uuid,
            'household_id' => $faker->uuid,
    		'week_number' => $faker->randomDigitNotNull,
    		'day_of_week' => $faker->randomDigitNotNull,
    		'slot' => 'dinner',
    	);
    	DB::table('meals')->insert( $meals );
    }
}