<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeleteToQuestions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('questions', function(Blueprint $table)
		{
            $table->timestamp('deleted_at')->nullable()->default(NULL);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('questions', function(Blueprint $table)
		{
            $table->dropColumn('deleted_at');
		});
	}

}
