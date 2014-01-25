<?php

class RecipeTableSeeder extends Seeder {

    public function run()
    {
    	$faker = \Faker\Factory::create();
    	$recipes = array(
    		'id' => $faker->uuid,
    		'user_id' => $faker->uuid,
    		'name' => $faker->name,
    		'description' => $faker->text,
    		'instructions' => $faker->address,
            'picture_id' => $faker->uuid,
            'number_of_portions' => $faker->randomDigit,
            'preparation_time' => $faker->time,
            'cooking_time' => $faker->time,
    	);
    	DB::table('recipes')->insert( $recipes );
    }
}