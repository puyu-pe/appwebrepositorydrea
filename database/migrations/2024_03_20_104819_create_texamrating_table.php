<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTexamratingTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('texamrating', function (Blueprint $table) {
			$table->char('idExamRating', 13)->primary();
			$table->char('idExam', 13);
			$table->char('idUser', 13);
			$table->enum('rating', ['1', '2', '3', '4', '5']);
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
		Schema::dropIfExists('texamrating');
	}
}
