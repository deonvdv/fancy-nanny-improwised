<?php

use \Models;

class EventTableSeeder extends Seeder {

    public function run()
    {


        $faker = \Faker\Factory::create();
        $types = ['travel', 'call', 'meeting'];
        $households = \Models\Household::all();
        $users = \Models\User::all();

        for ($i = 0; $i < 100; $i++) {
            $event = new \Models\Event();

            $event->title = ucwords($faker->bs);
            $event->description = $faker->text;
            $event->location = $faker->address;
            $event->event_date = $faker->dateTimeBetween($startDate = 'now', $endDate = '+ 2 years');
            $event->event_start_time = $faker->time($format = 'H:i:0');
            $event->event_end_time = $faker->time($format = 'H:i:0');
            $event->all_day = $faker->boolean;
            $event->notify = $faker->boolean;
            $event->minutes_before = $faker->randomDigitNotNull;
            $event->type = $types[rand(0, count($types)-1)];

            $users[rand(0, count($users)-1)]->events()->save($event);
            $households[rand(0, count($households)-1)]->events()->save($event);

        }






    }
}