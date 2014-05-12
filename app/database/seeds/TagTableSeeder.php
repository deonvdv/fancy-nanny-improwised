<?php

class TagTableSeeder extends Seeder {

    public function run()
    {
    	$faker = \Faker\Factory::create();
    	$tags = array(
    		'id' => $faker->uuid,
            'owner_id' => $faker->uuid,
    		'name' => $faker->name,
            'color' => substr($faker->colorName,0,7),
            'fontcolor' => 'black'
    	);
    	DB::table('tags')->insert( $tags );
    }
}