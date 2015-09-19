<?php

use Illuminate\Database\Seeder;

use App\UserRole as UserRole;

class UserRoleTableSeeder extends Seeder {

	/**
	 * Run the database seed.
	 *
	 * @return void
	 */
	public function run()
	{
		UserRole::create([
			'user_id' => 2, //Jaime
			'role_id' => 3, //parent
			'facility_id' => 1 //default
		]);

		UserRole::create([
			'user_id' => 3, //Maria
			'role_id' => 3, //parent
			'facility_id' => 1 //default
		]);

		UserRole::create([
			'user_id' => 2, //jaime
			'role_id' => 3, //parent
			'facility_id' => 1 //default
		]);

		UserRole::create([
			'user_id' => 4, //Will
			'role_id' => 4, //emergency_contact
			'facility_id' => 1 //default
		]);

		UserRole::create([
			'user_id' => 5, //Florinda
			'role_id' => 4, //emergency_contact
			'facility_id' => 1 //default
		]);

		UserRole::create([
			'user_id' => 6, //William
			'role_id' => 4, //emergency_contact
			'facility_id' => 1 //default
		]);

		UserRole::create([
			'user_id' => 7, //Nina Lao MD
			'role_id' => 5, //physician
			'facility_id' => 1 //default
		]);
	}

}
