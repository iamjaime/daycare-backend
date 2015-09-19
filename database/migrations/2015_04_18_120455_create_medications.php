<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedications extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Medications belong to children
		Schema::create('medications', function(Blueprint $table)
		{
			$table->increments('id');
			//Foreign Key Referencing the client_id on the clients table.
			$table->integer('facility_id')->unsigned();
			$table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');
			
			//Foreign Key Referencing the child_id on the childrens table.
			$table->integer('child_id')->unsigned();
			$table->foreign('child_id')->references('id')->on('children')->onDelete('cascade');

			$table->string('med_name'); //medication name
			$table->string('dosage'); //medication dosage
			$table->dateTime('when_to_take'); //what date and time to take
			$table->boolean('taken')->default(false); //was it taken?
				
			//Foreign Key Referencing the user_id on the users table that gave the child the med.
			$table->integer('given_by_user_id')->unsigned();
			$table->foreign('given_by_user_id')->references('id')->on('users')->onDelete('cascade');


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
		Schema::dropIfExists('medications');
	}

}
