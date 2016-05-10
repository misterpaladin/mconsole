<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMconsoleUploadPresetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mconsole_upload_presets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->nullable();
            $table->string('name')->nullable();
            $table->string('path')->nullable();
            $table->integer('width')->default(0);
            $table->integer('height')->default(0);
            $table->string('watermark')->nullable();
            $table->string('position')->nullable();
            $table->integer('quality')->default(95);
            $table->string('extensions')->nullable();
            $table->integer('min_width')->default(0);
            $table->integer('min_height')->default(0);
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
        Schema::drop('mconsole_upload_presets');
    }
}
