<?php

class NotificationTableSeeder extends Seeder {

    public function run()
    {
    	$faker = \Faker\Factory::create();
    	$notifications = array(
    		'id' => $faker->uuid,
    		'household_id' => $faker->uuid,
    		'user_id' => $faker->uuid,
    		'to' => $faker->email,
    		'message' => $faker->text,
    		'reference' => $faker->name,
    	);
    	DB::table('notifications')->insert( $notifications );
    }
}