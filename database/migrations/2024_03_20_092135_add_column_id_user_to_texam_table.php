<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIdUserToTexamTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('texam', function (Blueprint $table) {
			$table->char('idUser', 13)
				->after('idDirection')
				->nullable(false);

			$table->foreign('idUser')->references('idUser')->on('tuser');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('texam', function (Blueprint $table) {
			$table->dropForeign(['idUser']);
			$table->dropColumn('idUser');
		});
	}
}
