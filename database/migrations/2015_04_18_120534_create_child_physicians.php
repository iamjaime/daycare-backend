<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChildPhysicians extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Doctors
		Schema::create('child_physicians', function(Blueprint $table)
		{
			$table->increments('id');
			//Foreign Key Referencing the client_id on the clients table.
			$table->integer('facility_id')->unsigned();
			$table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');
			
			//Foreign Key Referencing the child_id on the childrens table.
			$table->integer('child_id')->unsigned();
			$table->foreign('child_id')->references('id')->on('children')->onDelete('cascade');

			//Foreign Key Referencing the user_id on the users table - The doctor's id.
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

			//Physician Type
			$table->string('type')->nullable(); 

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('child_physicians');
	}

}
