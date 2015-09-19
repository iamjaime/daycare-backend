<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncidents extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Incident Reports
		Schema::create('incidents', function(Blueprint $table)
		{
			$table->increments('id');
			//Foreign Key Referencing the client_id on the clients table.
			$table->integer('facility_id')->unsigned();
			$table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');
			//Foreign Key Referencing the child_id on the childrens table.
			$table->integer('child_id')->unsigned();
			$table->foreign('child_id')->references('id')->on('children')->onDelete('cascade');
			

			$table->dateTime('when'); //When did this incident happen?
			$table->string('where'); //where did this incident happen? Example: Kitchen, Playground etc.
			$table->mediumText('description'); //What happend?
			$table->mediumText('injuries'); //What type of injuries?
			$table->mediumText('service_provided'); //What type of medical services or treatment provided.
			$table->string('who_was_notified'); //Who was notified? Parent/Guardian/Emergency Contact. Etc.

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
		Schema::dropIfExists('incidents');
	}

}
