<?php

use \Model\Household;

class UserTableSeeder extends Seeder {

    public function run()
    {
        $roles = ['parent','guardian','child','staff'];
        $households = Household::all();

        $tmp = [
            'name'               => "Deon van der Vyver",
            'email'              => "deonvdv@gmail.com",
            'password'           => Hash::make("xxx"),
            'street'             => "My Street",
            'city'               => "Cadiz",
            'state'              => "Cadiz",
            'zip'                => "11011",
            'country'            => "Spain",
            'home_number'        => "",
            'work_number'        => "",
            'role'               => "admin",
            'active'             => 1,
            'profile_picture'    => "http://lorempixel.com/250/250/people/",
            'app_settings'       => json_encode( array("preferred_notification" => 'email' ) ),
        ];
        // print_r($tmp);

        $user = User::create($tmp);

        // Use Faker - https://github.com/fzaninotto/Faker
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $tmp = [
                'name'               => $faker->name,
                'household_id'       => $households[rand(0, count($households)-1)]->id,
                'email'              => $faker->email,
                'password'           => Hash::make($faker->word . strtoupper($faker->randomLetter) . $faker->randomDigitNotNull . $faker->word),
                'street'             => $faker->streetAddress,
                'city'               => $faker->city,
                'state'              => $faker->state,
                'zip'                => $faker->postcode,
                'country'            => $faker->country,
                'home_number'        => $faker->optional($weight = 0.5)->phoneNumber,
                'work_number'        => $faker->optional($weight = 0.5)->phoneNumber,
                'role'               => $roles[rand(0, 3)],
                'active'             => $i === 0 ? true : rand(0, 1),
                'profile_picture'    => $faker->imageUrl(250, 250, "people"),
                'app_settings'       => json_encode( array("preferred_notification" => rand(0, 1) ? 'email' : 'text' ) ),

                // // 'active'             => $i === 0 ? true : rand(0, 1),
                // // 'gender'             => rand(0, 1) ? 'male' : 'female',
                // // 'timezone'           => mt_rand(-10, 10),
                // // 'birthday'           => rand(0, 1) ? $faker->dateTimeBetween('-40 years', '-18 years') : null,
                // // 'location'           => rand(0, 1) ? "{$faker->city}, {$faker->state}" : null,
                // // 'had_feedback_email' => (bool) rand(0, 1),
                // // 'sync_name_bio'      => (bool) rand(0, 1),
                // // 'bio'                => $faker->sentence(100),
                // // 'picture_url'        => $this->picture_url[rand(0, 19)],
            ];
            // print_r($tmp);

            $user = User::create($tmp);
        }

    }

}