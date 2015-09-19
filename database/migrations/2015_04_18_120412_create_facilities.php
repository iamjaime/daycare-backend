<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacilities extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Child Care Facilities
		Schema::create('facilities', function(Blueprint $table)
		{
			$table->increments('id');
			//Foreign Key Referencing the user_id on the users table.
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->string('name');
			$table->string('address');
			$table->string('city');
			$table->string('province');
			$table->string('postal_code');
			$table->string('primary_phone');
			$table->string('fax')->nullable();
			$table->string('logo_url')->nullable();
			$table->string('api_auth_token');
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
		Schema::dropIfExists('facilities');
	}

}
