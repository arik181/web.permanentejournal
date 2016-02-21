<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCreditsToCertificates extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('certificates', function(Blueprint $table)
		{
			$table->integer('credits');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('certificates', function(Blueprint $table)
		{
			$table->dropColumn('credits');
		});
	}

}
