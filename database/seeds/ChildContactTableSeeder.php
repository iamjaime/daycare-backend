<?php

use Illuminate\Database\Seeder;

use App\ChildContact as ChildContact;

class ChildContactTableSeeder extends Seeder {

	/**
	 * Run the database seed.
	 *
	 * @return void
	 */
	public function run()
	{
		ChildContact::create([
			'user_id' => 4, //Will
			'child_id' => 1, //Isabel
			'facility_id' => 1, //default
			'relationship' => 'Uncle'
		]);

		ChildContact::create([
			'user_id' => 4, //Will
			'child_id' => 2, //Alyssa
			'facility_id' => 1, //default
			'relationship' => 'Uncle'
		]);

		ChildContact::create([
			'user_id' => 5, //Florinda
			'child_id' => 1, //Isabel
			'facility_id' => 1, //default
			'relationship' => 'Grandma'
		]);

		ChildContact::create([
			'user_id' => 5, //Florinda
			'child_id' => 2, //Alyssa
			'facility_id' => 1, //default
			'relationship' => 'Grandma'
		]);

		ChildContact::create([
			'user_id' => 6, //William
			'child_id' => 1, //Isabel
			'facility_id' => 1, //default
			'relationship' => 'Grandpa'
		]);

		ChildContact::create([
			'user_id' => 6, //William
			'child_id' => 2, //Alyssa
			'facility_id' => 1, //default
			'relationship' => 'Grandpa'
		]);
	}

}
