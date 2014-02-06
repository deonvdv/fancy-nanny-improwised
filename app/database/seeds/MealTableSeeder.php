<?php

class MealTableSeeder extends Seeder {

    public function run()
    {
    	$faker = \Faker\Factory::create();
 		// $meals = array(
   //  		'id' => $faker->uuid,
   //          'household_id' => $faker->uuid,
   //  		'week_number' => $faker->randomDigitNotNull,
   //  		'day_of_week' => $faker->randomDigitNotNull,
   //  		'slot' => 'dinner',
   //  	);
   //  	DB::table('meals')->insert( $meals );

        $slots = ['breakfast', 'lunch', 'dinner'];
        $households = \Models\Household::all();
        $recipe = \Models\Recipe::first();
        for ($i = 0; $i < 20; $i++) {

            $meal = new \Models\Meal();
            $meal->household()->associate($households[rand(0, count($households)-1)]);
            $meal->week_number = $faker->randomDigitNotNull;
            $meal->day_of_week = $faker->randomDigitNotNull;
            $meal->slot = $slots[rand(0,2)];
            $meal->addRecipe($recipe);
        }

    }
}