<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsToAnyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags_to_any', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tag_id');
            $table->integer('related_id')->nullable();
            $table->string('related_class')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tags_to_any');
    }
}
