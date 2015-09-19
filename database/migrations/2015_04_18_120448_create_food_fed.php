<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodFed extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Food fed to each child by provider
		Schema::create('food_fed', function(Blueprint $table)
		{
			$table->increments('id');
			//Foreign Key Referencing the facility_id on the clients table.
			$table->integer('facility_id')->unsigned();
			$table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');
			
			//Foreign Key Referencing the food_item_id on the food items table.
			$table->integer('food_item_id')->unsigned();
			$table->foreign('food_item_id')->references('id')->on('food_items')->onDelete('cascade');

			//Foreign Key Referencing the child_id on the childrens table.
			$table->integer('child_id')->unsigned();
			$table->foreign('child_id')->references('id')->on('children')->onDelete('cascade');

			//$table->string('type'); //Breakfast, Lunch, Supper, Snack
			$table->enum('serving_type', ['breakfast', 'lunch', 'supper', 'snack']);

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
		Schema::dropIfExists('food_fed');
	}

}
