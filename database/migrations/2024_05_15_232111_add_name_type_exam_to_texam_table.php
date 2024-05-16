<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameTypeExamToTexamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('texam', function (Blueprint $table) {
            $table->text('name_type_exam')->nullable()->after('descriptionExam');
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
            $table->dropColumn('name_type_exam');
        });
    }
}
