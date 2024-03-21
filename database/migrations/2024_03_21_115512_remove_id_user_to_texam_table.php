<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveIdUserToTexamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('texam', function (Blueprint $table) {
            Schema::table('texam', function (Blueprint $table) {
                $table->dropForeign(['idUser']);
                $table->dropColumn('idUser');
            });
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
            $table->char('idUser', 13)
                ->after('idDirection')
                ->nullable(true);

            $table->foreign('idUser')->references('idUser')->on('tuser');
        });
    }
}
