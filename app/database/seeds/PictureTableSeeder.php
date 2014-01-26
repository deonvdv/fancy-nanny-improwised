<?php

class PictureTableSeeder extends Seeder {

    public function run()
    {
    	$faker = \Faker\Factory::create();
    	$pictures = array(
            'id' => $faker->uuid,
            'owner_id' => $faker->uuid,
            'name' => $faker->name,
            'file_name' => $faker->name,
            'cdn_url' => $faker->url,
        );
        DB::table('pictures')->insert( $pictures );
    }
}