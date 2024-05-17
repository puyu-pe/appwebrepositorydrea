<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableTanswer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('tanswer');

        Schema::create('tanswer', function (Blueprint $table) {
            $table->char('idAnswer', 13)->primary();
            $table->char('idExam', 13);
            $table->char('idUser', 13);
            $table->enum('type', ['correct', 'verify', 'reviewed']);
            $table->timestamps();
        });

        Schema::create('tanswerdetail', function (Blueprint $table) {
            $table->char('idAnswerDetail', 13)->primary();
            $table->char('idAnswer', 13);
            $table->integer('numberAnswer')->unsigned();
            $table->text('descriptionAnswer');
            $table->boolean('is_correct');
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
        Schema::dropIfExists('tanswerdetail');
        Schema::dropIfExists('tanswer');

        Schema::create('tanswer', function (Blueprint $table) {
            $table->char('idAnswer', 13)->primary();
            $table->char('idExam', 13);
            $table->char('idUser', 13);
            $table->integer('numberAnswer')->unsigned();
            $table->text('descriptionAnswer');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });

        Schema::table('tanswer', function (Blueprint $table) {
            $table->foreign('idExam')->references('idExam')->on('texam')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('idUser')->references('idUser')->on('tuser')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->index('idExam');
        });
    }
}
