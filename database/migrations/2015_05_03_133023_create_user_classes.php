<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserClasses extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_classes', function(Blueprint $table)
		{
			$table->increments('id');
			//Foreign Key Referencing the facility_id on the facilities table.
			$table->integer('facility_id')->unsigned();
			$table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

			$table->integer('class_id')->unsigned();
			$table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');

			$table->boolean('complete')->default(false); //is class complete?

			$table->timestamps(); //when is the class being taken
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('user_classes');
	}

}
