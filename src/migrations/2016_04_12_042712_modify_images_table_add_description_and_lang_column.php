<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyImagesTableAddDescriptionAndLangColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->text('description')->after('preset_id');
            $table->string('title')->after('preset_id');
            $table->integer('language_id')->after('preset_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('title');
            $table->dropColumn('language_id');
        });
    }
}
