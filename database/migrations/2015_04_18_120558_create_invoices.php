<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoices extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Invoices - Holds the invoicing info for the child care facility.
		//Will probably code up business Projections based on invoice data.
		//This way I can show them a projection or estimated income for the year etc.
		Schema::create('invoices', function(Blueprint $table)
		{
			$table->increments('id');
			//Foreign Key Referencing the client_id on the clients table.
			$table->integer('facility_id')->unsigned();
			$table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');
			//Foreign Key Referencing the child_id on the childrens table.
			$table->integer('child_id')->unsigned();
			$table->foreign('child_id')->references('id')->on('children')->onDelete('cascade');
			//$table->string('status'); //paid, unpaid
			$table->enum('status', ['paid', 'unpaid']);
			$table->integer('amount'); //in pennies
			$table->integer('amount_paid'); //in pennies
			$table->string('type'); //cash, check, money order etc.
			$table->dateTime('payment_due');

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
		Schema::dropIfExists('invoices');
	}

}
