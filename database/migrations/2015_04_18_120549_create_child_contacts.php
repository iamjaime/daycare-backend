<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChildContacts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Child Contacts - Holds the child's authorized contacts for pick-up and for emergency purposes.
		//This is a pivot table
		Schema::create('child_contacts', function(Blueprint $table)
		{
			$table->increments('id');
			//Foreign Key Referencing the client_id on the clients table.
			$table->integer('facility_id')->unsigned();
			$table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');
			//Foreign Key Referencing the child_id on the childrens table.
			$table->integer('child_id')->unsigned();
			$table->foreign('child_id')->references('id')->on('children')->onDelete('cascade');

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

			$table->string('relationship'); //Example: Brother, Sister, Aunt, Uncle, Etc.

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('child_contacts');
	}

}
