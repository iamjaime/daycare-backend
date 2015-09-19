<?php

use Illuminate\Database\Seeder;

use App\Certificate as Certificate;

class CertificateTableSeeder extends Seeder {

	/**
	 * Run the database seed.
	 *
	 * @return void
	 */
	public function run()
	{	
		Certificate::create([
			'name' => '30 Hour - Professional Development',
			'renews' => '2 years'
		]);
	}

}
