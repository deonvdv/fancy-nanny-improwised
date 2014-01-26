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


        $faker = \Faker\Factory::create();
        $households = \Models\Household::all();

        for ($i = 0; $i < 100; $i++) {

            $doc = new \Models\Meal();
            $doc->name = ucwords($faker->bs);
            $doc->file_name = $fileName;
            $doc->cdn_url = $faker->url.$faker->uuid."/".$fileName;

            // $doc->save();
            // 
            $users[rand(0, count($users)-1)]->documents()->save($doc);
            $households[rand(0, count($households)-1)]->documents()->save($doc);

        }

    }
}