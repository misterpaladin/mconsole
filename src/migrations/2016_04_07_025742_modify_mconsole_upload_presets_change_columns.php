<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyMconsoleUploadPresetsChangeColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mconsole_upload_presets', function (Blueprint $table) {
            $table->dropColumn('key');
            $table->dropColumn('position');
            $table->dropColumn('watermark');
            $table->dropColumn('quality');
            $table->dropColumn('width');
            $table->dropColumn('height');
            $table->text('operations')->after('path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mconsole_upload_presets', function (Blueprint $table) {
            $table->string('width')->after('id');
            $table->string('height')->after('id');
            $table->string('quality')->after('id');
            $table->string('watermark')->after('id');
            $table->string('position')->after('id');
            $table->string('key')->after('id');
            $table->dropColumn('operations');
        });
    }
}
