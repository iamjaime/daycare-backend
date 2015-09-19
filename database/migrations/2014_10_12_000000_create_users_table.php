<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('address');
			$table->string('city');
			$table->string('province');
			$table->string('postal_code');
			$table->string('primary_phone');
			$table->string('alternate_phone')->nullable();
			$table->string('work_phone')->nullable();
			$table->string('email')->unique()->nullable(); //nullable for emergency contacts
			$table->string('password', 60);
			$table->enum('status', ['active', 'deactive'])->default('deactive');
			$table->rememberToken();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('users');
	}

}
