<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPreviewContentToArticle extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('articles', function(Blueprint $table)
		{
            $table->text('preview_content');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('articles', function(Blueprint $table)
		{
            $table->dropColumn('preview_content');
		});
	}

}
