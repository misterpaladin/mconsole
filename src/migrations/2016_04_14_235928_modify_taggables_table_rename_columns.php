<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTaggablesTableRenameColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('taggables', function (Blueprint $table) {
            $table->renameColumn('related_id', 'taggable_id');
            $table->renameColumn('related_class', 'taggable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('taggables', function (Blueprint $table) {
            $table->renameColumn('taggable_id', 'related_id');
            $table->renameColumn('taggable_type', 'related_class');
        });
    }
}
