<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAnswersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('answers', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('question_id');
            $table->text('answer_text');
            $table->tinyInteger('is_correct')->default(0);
            $table->timestamp('deleted_at')->nullable()->default(NULL);
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
		Schema::drop('answers');
	}

}
