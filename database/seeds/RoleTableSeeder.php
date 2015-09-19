<?php

use Illuminate\Database\Seeder;

use App\Role as Role;

class RoleTableSeeder extends Seeder {

	/**
	 * Run the database seed.
	 *
	 * @return void
	 */
	public function run()
	{
		Role::create(['type' => 'admin']);
		Role::create(['type' => 'staff']);
		Role::create(['type' => 'parent']);
		Role::create(['type' => 'emergency_contact']);
		Role::create(['type' => 'physician']); //Child Physician
	}

}
