<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
		//Seeding must be performed in order due to foreign key constraints.
		$this->call('RoleTableSeeder');
		$this->call('UserTableSeeder');
		$this->call('FacilitiesTableSeeder');
		$this->call('UserRoleTableSeeder');
		$this->call('ChildrenTableSeeder');
		$this->call('ChildParentTableSeeder');
		$this->call('ChildContactTableSeeder');
		$this->call('ClassesTableSeeder');
		$this->call('CertificateTableSeeder');
		$this->call('CertificateClassTableSeeder');
	}

}
