<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyMconsoleMenusTableAddDescriptionColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mconsole_menus', function (Blueprint $table) {
			$table->string('description')->after('url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mconsole_menus', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
}
