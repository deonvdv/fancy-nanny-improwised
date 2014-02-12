<?php


class TestCase extends Illuminate\Foundation\Testing\TestCase {

	/**
	 * Creates the application.
	 *
	 * @return \Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function createApplication()
	{
		$unitTesting = true;

		$testEnvironment = 'testing';

		return require __DIR__.'/../../bootstrap/start.php';
	}

	public function testTrueisTrue()
	{
		$this->assertTrue( true );
	}

	public function createFakeUser(\Models\Household $household = null,\Models\Picture $profilepic = null) {
    	$faker = \Faker\Factory::create();
		
		// Get household
		$roles = ['parent','guardian','child','staff'];
		
		if(!$profilepic){
			$profilepic = $this->createFakePicture();
		}		

		$tmp = [
            'name'               => $faker->name.' seed user',
            'email'              => $faker->email,
            'password'           => Hash::make($faker->word . strtoupper($faker->randomLetter) . $faker->randomDigitNotNull . $faker->word),
            'street'             => $faker->streetAddress,
            'city'               => $faker->city,
            'state'              => $faker->state,
            'zip'                => $faker->postcode,
            'country'            => substr($faker->country,0,50),
            'home_number'        => $faker->optional($weight = 0.5)->phoneNumber,
            'work_number'        => $faker->optional($weight = 0.5)->phoneNumber,
            'role'               => $roles[rand(0, 3)],
            'app_settings'       => json_encode( array("preferred_notification" => rand(0, 1) ? 'email' : 'text' ) ),
        	'profile_picture_id' => $profilepic->id,
        ];

        // var_dump($tmp);
        $user = new \Models\User( $tmp );

        if(!$household){
        	$household = $this->createFakeHousehold();
        }

        $user->setHousehold( $household );
        

        $user->save();

        return $user;
	}

	public function createFakeHousehold() {
    	$faker = \Faker\Factory::create();

		$contacts = ["Father", "Mother", "Sister", "Brother", "Aunt", "Uncle", "Grandfather", "Grandmother"];
		$emergency_contacts = json_encode( [ 
		        			$contacts[rand(0, 7)] => ["name" => $faker->name, "contact_number" => $faker->phoneNumber, "contact_email" => $faker->safeEmail], 
		        			$contacts[rand(0, 7)] => ["name" => $faker->name, "contact_number" => $faker->phoneNumber, "contact_email" => $faker->safeEmail], 
		        			$contacts[rand(0, 7)] => ["name" => $faker->name, "contact_number" => $faker->phoneNumber, "contact_email" => $faker->safeEmail], 
		        			$contacts[rand(0, 7)] => ["name" => $faker->name, "contact_number" => $faker->phoneNumber, "contact_email" => $faker->safeEmail], 
		        			] );

		$household = new \Models\Household();

		$household->name = $faker->unique()->lastName . " Household";
		$household->emergency_contacts = $emergency_contacts;
		$household->critical_information = $faker->paragraph($nbSentences = 3);

        $household->save();
	
		return $household;
	}

	public function createFakeUserWithFakeHousehold() {
		$household = $this->createFakeHousehold();
		$profilepic = $this->createFakePicture();
		$user = $this->createFakeUser($household, $profilepic);
		return $user;
	}

	public function createFakeDocument(\Models\User $owner = null) {
    	$faker = \Faker\Factory::create();

		$doc = new \Models\Document( array( 
			"name"      => ucwords($faker->bs), 
			"file_name" => $faker->word.'.'.$faker->fileExtension, 
			"cdn_url"	=> $faker->word,  
			"private"   => false ) );

		if ( $owner )
			$doc->setOwner( $owner );

        $doc->save();

		return $doc;
	}

	public function createFakeMessage(\Models\User $sender, \Models\User $receiver = null) {
    	$faker = \Faker\Factory::create();

		$sender->save();
		$sender->save();

		$msg = new \Models\Message( array( 
			"sender_id" => $sender->id, 
			"household_id" => $sender->household->id,
			"receiver_id" => ($receiver) ? $receiver->id : '', 
			"message" => $faker->paragraph($nbSentences = 5) ) );

		$msg->save();

		return $msg;		
	}

	public function createFakeTag(\Models\User $owner = null) {
    	$faker = \Faker\Factory::create();

		$tag = new \Models\Tag( array( 
			'name'         => $faker->sentence(3, false),
			'color'        => $faker->hexcolor ) );

		if ( $owner )
			$tag->setOwner( $owner );

		return $tag;		
	}

	public function createFakeTodo(\Models\User $owner = null ){
		$faker = \Faker\Factory::create();

		$todo = new \Models\Todo( array(
			'title' 		=> $faker->text(15),
			'description'	=> $faker->text,
			'due_date'		=> $faker->date,
			'is_complete'	=> false,
			'notify'		=> $faker->word, ));

		if( $owner )
			$todo->setOwner( $owner );

		return $todo;

	}

	public function createFakeRecipe() {
    	$faker = \Faker\Factory::create();

		$recipe = new \Models\Recipe();

		$recipe->name = $faker->name;
		$recipe->description = $faker->text;
		$recipe->instructions = $faker->text;
		$recipe->number_of_portions = $faker->randomDigit;
		$recipe->preparation_time = $faker->time;
		$recipe->cooking_time = $faker->time;
		$user = $this->createFakeUser();
		$recipe->setAuthor($user);
		//$recipe->save();

		return $recipe;
	}

	public function createFakePicture(\Models\User $owner = null) {
    	$faker = \Faker\Factory::create();

    	$tmp = array(
            'name' => $faker->bs,
            'file_name' => $faker->name . "." . $faker->fileExtension,
            'cdn_url' => $faker->url,           
        );

		$pic = new \Models\Picture( $tmp );
		
		// Add the Picture Owner
		if ( $owner )
			$pic->owner()->associate($owner);			
		
		return $pic;

	}
}
