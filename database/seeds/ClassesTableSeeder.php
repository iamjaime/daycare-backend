<?php

use Illuminate\Database\Seeder;

use App\Classes as Classes;

class ClassesTableSeeder extends Seeder {

	/**
	 * Run the database seed.
	 *
	 * @return void
	 */
	public function run()
	{	
		// 15/30 hours - Professional Development (default seeder data)
		Classes::create(['name' => 'Principles of childhood development']);
		Classes::create(['name' => 'Nutrition and health needs of children']);
		Classes::create(['name' => 'Child day care program development']);
		Classes::create(['name' => 'Safety and security procedures, including communication between parents and staff']);
		Classes::create(['name' => 'Business-record maintenance and management']);
		Classes::create(['name' => 'Child abuse and maltreatment identification and prevention']);
		Classes::create(['name' => 'Statutes and regulations pertaining to child care']);
		Classes::create(['name' => 'Statutes and regulation pertaining to child abuse and maltreatment']);
		Classes::create(['name' => 'Shaken Baby Syndrome']);
		Classes::create(['name' => 'Sudden Infant Death Syndrome (SIDS)']);
	}

}
