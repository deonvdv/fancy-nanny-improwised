<?php

class DocumentTableSeeder extends Seeder {

    public function run()
    {
    	$faker = \Faker\Factory::create();
        $households = \Models\Household::all();
        $users = \Models\User::all();

        for ($i = 0; $i < 100; $i++) {
            $fileName = $faker->word.'.'.$faker->fileExtension;

            $doc = new \Models\Document();
            // $doc->household->associate( $households[rand(0, count($households)-1)] );
            // $doc->user->associate( $users[rand(0, count($households)-1)] );
            // $doc->household = $users[rand(0, count($households)-1)];
            // $doc->user = $users[rand(0, count($users)-1)];
            $doc->name = ucwords($faker->bs);
            $doc->file_name = $fileName;
            $doc->cdn_url = $faker->url.$faker->uuid."/".$fileName;

            // $doc->save();
            // 
            $users[rand(0, count($users)-1)]->documents()->save($doc);
            $households[rand(0, count($households)-1)]->documents()->save($doc);

        }
    }
}