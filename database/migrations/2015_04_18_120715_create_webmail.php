<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebmail extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Web mail and notifications
		Schema::create('webmail', function(Blueprint $table)
		{
			$table->increments('id');
			//Foreign Key Referencing the facility_id on the facilities table.
			$table->integer('facility_id')->unsigned();
			$table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');
			
			$table->enum('status', ['unread', 'read', 'sent']); //notification statuses
			
			$table->string('subject');
			$table->longText('message'); //the message
			
			//Foreign Key Referencing the users table
			$table->integer('to_user_id')->unsigned();
			$table->foreign('to_user_id')->references('id')->on('users')->onDelete('cascade');

			//Foreign Key Referencing the users table
			$table->integer('from_user_id')->unsigned();
			$table->foreign('from_user_id')->references('id')->on('users')->onDelete('cascade');

			$table->timestamps();
			$table->softDeletes();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('webmail');
	}

}
