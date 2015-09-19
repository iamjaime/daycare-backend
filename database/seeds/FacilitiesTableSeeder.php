<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use App\Facility as Facility;

class FacilitiesTableSeeder extends Seeder {

	/**
	 * Run the database seed.
	 *
	 * @return void
	 */
	public function run()
	{
		$token = hash('sha256', Str::random(10),false);
		Facility::create([
			'user_id' => 1,
			'name' => 'Test Facility',
			'address' => '123 dummy street.',
			'city' => 'New York',
			'province' => 'NY',
			'postal_code' => '10001',
			'primary_phone' => '(212) 123-4567',
			'fax' => '(212) 555-5555',
			'logo_url' => 'http://placehold.it/350x65',
			'api_auth_token' => $token
		]);

		$token2 = hash('sha256', Str::random(10),false);
		
		Facility::create([
			'user_id' => 1,
			'name' => 'Second Facility',
			'address' => '123 dummy street.',
			'city' => 'New York',
			'province' => 'NY',
			'postal_code' => '10001',
			'primary_phone' => '(212) 123-4567',
			'fax' => '(212) 555-5555',
			'logo_url' => 'http://placehold.it/350x65',
			'api_auth_token' => $token2
		]);
	}

}
