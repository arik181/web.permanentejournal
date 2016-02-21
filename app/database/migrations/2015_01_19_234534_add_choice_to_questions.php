<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChoiceToQuestions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('questions', function(Blueprint $table)
		{
			$table->integer('question_choice');
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
            $table->dropColumn('question_choice');
		});
	}
}
