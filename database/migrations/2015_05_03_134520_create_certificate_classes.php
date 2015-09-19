<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificateClasses extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('certificate_classes', function(Blueprint $table)
		{
			//handles which courses are needed for a specific certificate.
			$table->increments('id');
			
			$table->integer('certificate_id')->unsigned();
			$table->foreign('certificate_id')->references('id')->on('certificates')->onDelete('cascade');

			$table->integer('class_id')->unsigned();
			$table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('certificate_classes');
	}

}
