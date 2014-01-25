<?php

class DocumentTableSeeder extends Seeder {

    public function run()
    {
    	$faker = \Faker\Factory::create();
    	$file_name = $faker->firstName;
    	$ext = $faker->fileExtension;
    	$file = $file_name.'.'.$ext;
    	$documents = array(
    		'id' => $faker->uuid,
    		'household_id' => $faker->uuid,
    		'user_id' => $faker->uuid,
    		'name' => $faker->name,
    		'file_name' => $file,
    		'cdn_url' => $faker->url,

    	);
    	DB::table('documents')->insert( $documents );
    }
}