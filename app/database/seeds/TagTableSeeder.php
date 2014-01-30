<?php

class TagTableSeeder extends Seeder {

    public function run()
    {
    	$faker = \Faker\Factory::create();
    	$tags = array(
    		'id' => $faker->uuid,
            'household_id' => $faker->uuid,
    		'user_id' => $faker->uuid,
    		'name' => $faker->name,
            'color' => substr($faker->colorName,0,7),
            'tagable_id'=> $faker->uuid,
            'tagable_type'=>$faker->name
    	);
    	DB::table('tags')->insert( $tags );
    }
}