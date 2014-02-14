<?php

class MessageTableSeeder extends Seeder {

    public function run()
    {
    	$faker = \Faker\Factory::create();
    	$messages = array(
    		'id' => $faker->uuid,
    		'sender_id' => $faker->uuid,
            'receiver_id' => $faker->uuid,
    		'message' => $faker->text,
    	);
    	DB::table('messages')->insert( $messages );
    }
}