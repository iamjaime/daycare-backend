<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//notes
		Schema::create('notes', function(Blueprint $table)
		{
			$table->increments('id');
			//Foreign Key Referencing the client_id on the clients table.
			$table->integer('facility_id')->unsigned();
			$table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');
			
			//Foreign Key Referencing the user_id on the users table that took the note.
			$table->integer('staff_id')->unsigned();
			$table->foreign('staff_id')->references('id')->on('users')->onDelete('cascade');

			//Foreign Key Referencing the child_id on the childrens table.
			$table->integer('child_id')->unsigned();
			$table->foreign('child_id')->references('id')->on('children')->onDelete('cascade');

			$table->string('title'); //note title
			$table->mediumText('note'); //note
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
		Schema::dropIfExists('notes');
	}

}
