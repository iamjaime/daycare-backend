<?php

use Illuminate\Database\Seeder;

use App\ChildParent as ChildParent;

class ChildParentTableSeeder extends Seeder {

	/**
	 * Run the database seed.
	 *
	 * @return void
	 */
	public function run()
	{
		ChildParent::create([
			'facility_id' => 1, //default
			'user_id' => 2, //Jaime
			'child_id' => 1, //Isabel
			'relationship' => 'Dad'
		]);

		ChildParent::create([
			'facility_id' => 1, //default
			'user_id' => 2, //Jaime
			'child_id' => 2, //Alyssa
			'relationship' => 'Dad'
		]);

		ChildParent::create([
			'facility_id' => 1, //default
			'user_id' => 3, //Maria
			'child_id' => 1, //Isabel
			'relationship' => 'Mom'
		]);

		ChildParent::create([
			'facility_id' => 1, //default
			'user_id' => 3, //Maria
			'child_id' => 2, //Alyssa
			'relationship' => 'Mom'
		]);
	}

}
