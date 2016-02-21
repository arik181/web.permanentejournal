<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdminColumn extends Migration {

	public function up()
	{
		Schema::table('users', function($table)
		{
			$table->integer('is_admin')->default(0);
		});
	}

	public function down()
	{
      $table->dropColumn('is_admin');
	}

}
