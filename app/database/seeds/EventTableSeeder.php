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
            $event->event_date = $faker->date;
            $event->event_start_time = $faker->time($format = 'H:i:s');
            $event->event_end_time = $faker->time($format = 'H:i:s');
            $event->all_day = $faker->boolean;
            $event->notify = $faker->boolean;
            $event->minutes_before = $faker->randomDigitNotNull;
            $event->type = $types[rand(0, count($types)-1)];

            $curhousehold = $households[rand(0, count($households)-1)];
            $event->household_id = $curhousehold->id;

            $users[rand(0, count($users)-1)]->events()->save($event);
            $curhousehold->events()->save($event);

        }






    }
}