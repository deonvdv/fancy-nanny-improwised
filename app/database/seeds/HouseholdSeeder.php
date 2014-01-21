<?php

use \Model\Household;

class HouseholdTableSeeder extends Seeder {

    public function run()
    {
        $faker = \Faker\Factory::create();
        $contacts = ["Father", "Mother", "Sister", "Brother", "Aunt", "Uncle", "Grandfather", "Grandmother"];

        for ($i = 0; $i < 10; $i++) {
	        Household::create(
	        	array(
	        		'name' => $faker->unique()->lastName . " Household",
	        		'emergency_contacts' => json_encode( 
		        		[ 
		        			$contacts[rand(0, 7)] => ["name" => $faker->name, "contact_number" => $faker->phoneNumber, "contact_email" => $faker->safeEmail], 
		        			$contacts[rand(0, 7)] => ["name" => $faker->name, "contact_number" => $faker->phoneNumber, "contact_email" => $faker->safeEmail], 
		        			$contacts[rand(0, 7)] => ["name" => $faker->name, "contact_number" => $faker->phoneNumber, "contact_email" => $faker->safeEmail], 
		        			$contacts[rand(0, 7)] => ["name" => $faker->name, "contact_number" => $faker->phoneNumber, "contact_email" => $faker->safeEmail], 
		        		]
		        	),
	        		'critical_information' => $faker->paragraph($nbSentences = 3),
	        	)
	        );
		}        
    }

}