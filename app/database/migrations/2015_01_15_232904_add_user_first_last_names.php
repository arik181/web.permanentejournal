<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserFirstLastNames extends Migration 
{
  public function up()
  {
    Schema::table('users', function($table)
    {
      $table->string('first_name');
      $table->string('last_name');
    });
  }

  public function down()
  {
    Schema::table('users', function($table)
    {
      $table->dropColumn('first_name');
      $table->dropColumn('last_name');
    });
  }
}
