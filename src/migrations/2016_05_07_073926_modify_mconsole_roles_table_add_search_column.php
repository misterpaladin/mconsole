<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyMconsoleRolesTableAddSearchColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mconsole_roles', function (Blueprint $table) {
            $table->boolean('search')->after('widget')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mconsole_roles', function (Blueprint $table) {
            $table->dropColumn('search');
        });
    }
}
