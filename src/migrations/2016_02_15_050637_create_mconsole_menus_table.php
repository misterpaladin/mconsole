<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMconsoleMenusTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mconsole_menus', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('menu_id')->default(0);
			$table->string('name');
			$table->string('url');
			$table->boolean('visible')->default(true);
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
		Schema::drop('mconsole_menus');
	}
}
