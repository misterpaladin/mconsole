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
        });
        Schema::table('mconsole_upload_presets', function (Blueprint $table) {
            $table->json('operations')->nullable()->after('path');
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
            $table->string('width')->nullable()->after('id');
            $table->string('height')->nullable()->after('id');
            $table->string('quality')->nullable()->after('id');
            $table->string('watermark')->nullable()->after('id');
            $table->string('position')->nullable()->after('id');
            $table->string('key')->nullable()->after('id');
        });
        Schema::table('mconsole_upload_presets', function (Blueprint $table) {
            $table->dropColumn('operations');
        });
    }
}
