<?php

class MessageTableSeeder extends Seeder {

    public function run()
    {
    	$faker = \Faker\Factory::create();
    	$messages = array(
    		'id' => $faker->uuid,
    		'household_id' => $faker->uuid,
    		'user_id' => $faker->uuid,
    		'message' => $faker->text,
    		'date' => $faker->date,
    	);
    	DB::table('messages')->insert( $messages );
    }
}