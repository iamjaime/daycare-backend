<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChildCheckins extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Child Checkin
		Schema::create('child_checkins', function(Blueprint $table)
		{
			$table->increments('id');
			//Foreign Key Referencing the client_id on the clients table.
			$table->integer('facility_id')->unsigned();
			$table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');
			//Foreign Key Referencing the child_id on the childrens table.
			$table->integer('child_id')->unsigned();
			$table->foreign('child_id')->references('id')->on('children')->onDelete('cascade');
			
			$table->boolean('checked_in')->default(false); //Did child checkin?
			$table->boolean('checked_out')->default(false); //Did child checkout?
			
			$table->timestamp('time_in')->nullable(); //what time checked in?
			$table->timestamp('time_out')->nullable(); //what time checked out?

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('child_checkins');
	}

}
