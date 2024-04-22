<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTresourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tresource', function (Blueprint $table) {
            $table->char('idResource', 13)->primary();
            $table->char('idExam', 13)->nullable();
            $table->string('namecompleteResource', 500);
            $table->string('type', 500);
            $table->string('extension', 7);
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });

        Schema::table('texam', function (Blueprint $table) {
            $table->date('dateExam')->after('register_answer')->nullable(true);
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
            $table->dropColumn('dateExam');
        });

        Schema::dropIfExists('tresource');
    }
}
