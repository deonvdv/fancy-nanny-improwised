<?php

class EventTableSeeder extends Seeder {

    public function run()
    {
    	$faker = \Faker\Factory::create();
    	$file_name = $faker->firstName;
    	$ext = $faker->fileExtension;
    	$file = $file_name.'.'.$ext;
    	$events = array(
    		'id' => $faker->uuid,
    		'household_id' => $faker->uuid,
    		'user_id' => $faker->uuid,
    		'title' => $faker->name,
    		'description' => $faker->text,
    		'location' => $faker->address,
            'event_date' => $faker->date,
            'event_time' => $faker->time,
            'all_day' => $faker->boolean,
            'notify' => $faker->name,
            'minutes_before' => $faker->time($format='00:i:s'),
            'type' => $faker->firstName,
    	);
    	DB::table('events')->insert( $events );
    }
}