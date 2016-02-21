<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeToArticlePartTwo extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('questions', function(Blueprint $table)
		{
            $table->enum('question_type', array('article','survey'));
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
            $table->dropColumn('question_type');
		});
	}

}
