<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKeyTypeAnswerToTexamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('texam', function (Blueprint $table) {
            $table->string('keyTypeAnswer')->after('register_answer');
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
            $table->dropColumn('keyTypeAnswer');
        });
    }
}
