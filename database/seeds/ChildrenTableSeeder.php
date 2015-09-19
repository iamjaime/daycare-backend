<?php

use Illuminate\Database\Seeder;

use App\Children as Children;

class ChildrenTableSeeder extends Seeder {

	/**
	 * Run the database seed.
	 *
	 * @return void
	 */
	public function run()
	{
		Children::create([
			'first_name' => 'Isabel',
			'last_name' => 'Bernal',
			'dob' => '2015-02-24',
			'facility_id' => 1, //default
			'gender' => 'female'
		]);

		Children::create([
			'first_name' => 'Alyssa',
			'last_name' => 'Bernal',
			'dob' => '2015-02-24',
			'facility_id' => 1, //default
			'gender' => 'female'
		]);
	}

}
