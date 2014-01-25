<?php

class UnitOfMeasureTableSeeder extends Seeder {

    public function run()
    {
    	$faker = \Faker\Factory::create();
    	$unit_of_measures = array(
    		'id' => $faker->uuid,
    		'name' => $faker->name,
    	);
    	DB::table('units_of_measure')->insert( $unit_of_measures );
    }
}