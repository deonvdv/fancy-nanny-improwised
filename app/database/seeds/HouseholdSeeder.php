<?php

use \Model\Household;

class HouseholdTableSeeder extends Seeder {

    public function run()
    {
        DB::table('households')->delete();

        Household::create(
        	array(
        		'name' => 'Jones Household',
        		'emergency_contacts' => 'Quos, cum, eos, at, laboriosam soluta labore culpa sunt commodi explicabo rem praesentium in quam ipsa cupiditate maiores excepturi qui nostrum error.',
        		'critical_information' => 'Hic, pariatur, dignissimos, adipisci nihil animi corporis iste cum tenetur nostrum est atque consequuntur ea quos magnam harum rem ipsa expedita rerum.',
        	)
        );

        Household::create(
        	array(
        		'name' => 'Smith Household',
        		'emergency_contacts' => 'At, harum vel dolorum numquam amet sint porro eius quidem ea cumque ad dolore praesentium earum totam autem magni veritatis voluptates quae.',
        		'critical_information' => 'Sit, atque accusamus necessitatibus delectus rerum earum reiciendis. Deleniti, nemo eos adipisci eveniet veniam officiis numquam unde neque aliquam sapiente vel omnis?.',
        	)
        );

        Household::create(
        	array(
        		'name' => 'Jackson Household',
        		'emergency_contacts' => 'Quidem, odio placeat iusto! Aut, doloribus, iusto ipsam soluta libero explicabo sed accusantium eum asperiores corporis repellendus quam ducimus est neque expedita..',
        		'critical_information' => 'Deserunt, nihil, illum, consequatur eveniet nostrum non velit laudantium quisquam impedit repudiandae ipsa sunt. Assumenda, ipsam maiores mollitia aperiam alias eius aspernatur?.',
        	)
        );
    }

}