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
			$table->decimal('purchase_cost', 10, 2)->required();
			$table->decimal('current_value', 10, 2)->required();
			$table->decimal('depreciation', 10, 2)->required();
			$table->decimal('net_book_value', 10, 2)->required();
			$table->date('transferred_at')->nullable();
			$table->timestamps();
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
