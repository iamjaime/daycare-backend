<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsurances extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Insurances
		Schema::create('insurances', function(Blueprint $table)
		{
			$table->increments('id');
			//Foreign Key Referencing the client_id on the clients table.
			$table->integer('facility_id')->unsigned();
			$table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');
			
			//Foreign Key Referencing the child_id on the childrens table.
			$table->integer('child_id')->unsigned();
			$table->foreign('child_id')->references('id')->on('children')->onDelete('cascade');

			$table->string('policy_name'); //policy name
			$table->string('policy_number'); //policy number
			$table->string('group_number'); //group number
			$table->date('expires'); //expires 
			
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
		Schema::dropIfExists('insurances');
	}

}
