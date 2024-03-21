<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNumberQuestionAndRenameStatusAnswerTexamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('texam', function (Blueprint $table) {
            $table->integer('number_question')->default(0)->after('numberEvaluation');
            $table->renameColumn('statusAnwser', 'register_answer');
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
            $table->dropColumn('number_question');
            $table->renameColumn('register_answer', 'statusAnwser');
        });
    }
}
