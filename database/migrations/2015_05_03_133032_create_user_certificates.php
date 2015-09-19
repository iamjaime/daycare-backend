<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCertificates extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_certificates', function(Blueprint $table)
		{
			$table->increments('id');
			
			//Foreign Key Referencing the facility_id on the facilities table.
			$table->integer('facility_id')->unsigned();
			$table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

			$table->integer('certificate_id')->unsigned();
			$table->foreign('certificate_id')->references('id')->on('certificates')->onDelete('cascade');

			$table->timestamp('expires_on'); //when does the certification expire?

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('user_certificates');
	}

}
