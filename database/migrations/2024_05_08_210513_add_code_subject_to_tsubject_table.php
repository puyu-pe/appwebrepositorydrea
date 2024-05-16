<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodeSubjectToTsubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tsubject', function (Blueprint $table) {
            $table->string('codeSubject', 10)->nullable()->after('nameSubject');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tsubject', function (Blueprint $table) {
            $table->dropColumn('codeSubject');
        });
    }
}
