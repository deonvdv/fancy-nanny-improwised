<?php

class MessageTableSeeder extends Seeder {

    public function run()
    {
    	$faker = \Faker\Factory::create();
    	$messages = array(
    		'id' => $faker->uuid,
    		'household_id' => $faker->uuid,
            'from_user_id' => $faker->uuid,
            'to_user_id' => $faker->uuid,
    		'message' => $faker->text,
    	);
    	DB::table('messages')->insert( $messages );
    }
}