<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('asset_id');
            $table->date('accounting_start')->required();
            $table->date('accounting_end')->required();
            $table->date('purchase_date')->required();
            $table->date('end_of_life')->required();
			$table->bigInteger('purchase_cost')->required();
			$table->bigInteger('current_value')->required();
			$table->bigInteger('depreciation')->required();
			$table->bigInteger('net_book_value')->required();
			$table->date('transferred_at')->nullable();
			$table->timestamps();
			$table->softDeletes();
        });

        Schema::table('finances', function (Blueprint $table) {
        	$table->foreign('asset_id')->references('id')->on('assets');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finances');
    }
}
