<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTanswerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tanswer', function (Blueprint $table) {
            $table->string('idUser', 13)->nullable()->change();

            $table->string('dni', 8)->after('idUser');
            $table->string('firstName', 100)->after('dni');
            $table->string('surName', 100)->after('firstName');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tanswer', function (Blueprint $table) {
            $table->string('idUser', 13)->nullable(false)->change();
            $table->dropColumn(['dni', 'firstName', 'surName']);
        });
    }
}
