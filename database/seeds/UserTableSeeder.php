<?php

use Illuminate\Database\Seeder;

use App\User as User;
use \Hash;

class UserTableSeeder extends Seeder {

	/**
	 * Run the database seed.
	 *
	 * @return void
	 */
	public function run()
	{
		//admin
		User::create([
			'first_name' => 'dummy',
			'last_name' => 'man',
			'address' => '123 example street.',
			'city' => 'New York',
			'province' => 'NY',
			'postal_code' => '10001',
			'primary_phone' => '(212) 123-4567',
			'alternate_phone' => '(212) 555-5555',
			'work_phone' => '(212) 222-2222',
			'email' => 'dummy@man.com',
			'password' => Hash::make('testing123'),
			'status' => 'active'
		]);
		//parent
		User::create([
			'first_name' => 'Jaime',
			'last_name' => 'Bernal',
			'address' => '123 example street.',
			'city' => 'New York',
			'province' => 'NY',
			'postal_code' => '10001',
			'primary_phone' => '(212) 123-4567',
			'alternate_phone' => '(212) 555-5555',
			'work_phone' => '(212) 222-2222',
			'email' => 'jaime@iamjaime.com',
			'password' => Hash::make('testing123'),
			'status' => 'active'
		]);
		//parent
		User::create([
			'first_name' => 'Maria',
			'last_name' => 'Contreras',
			'address' => '123 example street.',
			'city' => 'New York',
			'province' => 'NY',
			'postal_code' => '10001',
			'primary_phone' => '(212) 123-4567',
			'alternate_phone' => '(212) 555-5555',
			'work_phone' => '(212) 222-2222',
			'email' => 'kuromii96x33@hotmail.com',
			'password' => Hash::make('testing123'),
			'status' => 'active'
		]);

		//emergency_contact
		User::create([
			'first_name' => 'Will',
			'last_name' => 'Bernal',
			'address' => '123 example street.',
			'city' => 'New York',
			'province' => 'NY',
			'postal_code' => '10001',
			'primary_phone' => '(212) 123-4567',
			'alternate_phone' => '(212) 555-5555',
			'work_phone' => '(212) 222-2222',
			'status' => 'active'
		]);

		//emergency_contact
		User::create([
			'first_name' => 'Florinda',
			'last_name' => 'Bernal',
			'address' => '123 example street.',
			'city' => 'New York',
			'province' => 'NY',
			'postal_code' => '10001',
			'primary_phone' => '(212) 123-4567',
			'alternate_phone' => '(212) 555-5555',
			'work_phone' => '(212) 222-2222',
			'status' => 'active'
		]);

		//emergency_contact
		User::create([
			'first_name' => 'William',
			'last_name' => 'Bernal',
			'address' => '123 example street.',
			'city' => 'New York',
			'province' => 'NY',
			'postal_code' => '10001',
			'primary_phone' => '(212) 123-4567',
			'alternate_phone' => '(212) 555-5555',
			'work_phone' => '(212) 222-2222',
			'status' => 'active'
		]);

		//Doctor
		User::create([
			'first_name' => 'Nina',
			'last_name' => 'Lao',
			'address' => '123 example street.',
			'city' => 'New York',
			'province' => 'NY',
			'postal_code' => '10001',
			'primary_phone' => '(212) 123-4567',
			'alternate_phone' => '(212) 555-5555',
			'work_phone' => '(212) 222-2222',
			'status' => 'active'
		]);

		//staff
		User::create([
			'first_name' => 'Staff',
			'last_name' => 'Man',
			'address' => '123 example street.',
			'city' => 'New York',
			'province' => 'NY',
			'postal_code' => '10001',
			'primary_phone' => '(212) 123-4567',
			'alternate_phone' => '(212) 555-5555',
			'work_phone' => '(212) 222-2222',
			'email' => 'staff@man.com',
			'password' => Hash::make('testing123'),
			'status' => 'active'
		]);
	}

}
