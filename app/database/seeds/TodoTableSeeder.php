<?php

class TodoTableSeeder extends Seeder {

    public function run()
    {
    	$faker = \Faker\Factory::create();
    	$todos = array(
    		'id' => $faker->uuid,
    		'owner_id' => $faker->uuid,
    		'title' => $faker->name,
    		'description' => $faker->text,
    		'due_date' => $faker->date,
            'assigned_by' => $faker->uuid,
            'assigned_to' => $faker->uuid,
            'is_complete' => $faker->boolean,
            'notify' => $faker->name,
            'minutes_before' => $faker->randomDigitNotNull,
    	);
    	DB::table('todos')->insert( $todos );
    }
}