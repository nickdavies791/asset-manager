<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tag');
            $table->string('name');
            $table->string('serial_number')->nullable();
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->string('processor')->nullable();
            $table->string('memory')->nullable();
            $table->string('storage')->nullable();
            $table->string('operating_system')->nullable();
            $table->text('warranty')->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('assets');
    }
}
