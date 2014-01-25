<?php

class TodoTableSeeder extends Seeder {

    public function run()
    {
    	$faker = \Faker\Factory::create();
    	$todos = array(
    		'id' => $faker->uuid,
    		'household_id' => $faker->uuid,
            'user_id' => $faker->uuid,
    		'title' => $faker->name,
    		'description' => $faker->text,
    		'due_date' => $faker->date,
            'assigned_by' => $faker->uuid,
            'assigned_to' => $faker->uuid,
            'is_complete' => $faker->boolean,
            'notify' => $faker->name,
            'minutes_before' => $faker->time($format = '00:i:s'),
    	);
    	DB::table('todos')->insert( $todos );
    }
}