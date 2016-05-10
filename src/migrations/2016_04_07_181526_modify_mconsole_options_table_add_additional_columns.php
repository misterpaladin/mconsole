<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyMconsoleOptionsTableAddAdditionalColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mconsole_options', function (Blueprint $table) {
            $table->boolean('enabled')->default(true)->after('value');
            $table->enum('type', ['text', 'textarea', 'checkbox', 'select'])->after('value');
            $table->string('label')->nullable()->after('id');
            $table->text('value')->nullable()->change();
        });
        Schema::table('mconsole_options', function (Blueprint $table) {
            $table->json('options')->nullable()->after('value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mconsole_options', function (Blueprint $table) {
            $table->dropColumn('enabled');
            $table->dropColumn('options');
            $table->dropColumn('type');
            $table->dropColumn('label');
        });
        Schema::table('mconsole_options', function (Blueprint $table) {
            $table->string('value')->change();
        });
    }
}
