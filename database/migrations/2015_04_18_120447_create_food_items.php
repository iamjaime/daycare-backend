<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodItems extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Food Items for child care providers.
		Schema::create('food_items', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('calories'); //must contain calories for calculations of child calories intake.
			$table->decimal('serving_amount', 5, 2); //for calculations
			//$table->string('serving_type'); //the type can be grams, ounces,
			$table->enum('serving_type', ['grams', 'ounces']);
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
		Schema::dropIfExists('food_items');
	}

}
