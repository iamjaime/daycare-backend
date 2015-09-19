<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChildren extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Children belong to different clients AKA subscribers AKA facilities ALSO parents.
		Schema::create('children', function(Blueprint $table)
		{
			$table->increments('id');
			
			//Foreign Key Referencing the facility_id on the facilities table.
			$table->integer('facility_id')->unsigned();
			$table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');
			
			$table->string('first_name');
			$table->string('last_name');
			$table->date('dob');
			$table->string('gender');
			$table->string('blood_type')->nullable(); //if applicable

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
		Schema::dropIfExists('children');
	}

}
