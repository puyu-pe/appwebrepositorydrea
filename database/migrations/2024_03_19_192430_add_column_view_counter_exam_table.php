<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnViewCounterExamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('texam', function (Blueprint $table) {
            $table->integer('view_counter')
                ->after('extensionExam')
                ->default(0)
                ->nullable(false);
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
            $table->dropColumn('view_counter');
        });
    }
}
