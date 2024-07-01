<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTtestimonyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ttestimony', function (Blueprint $table) {
            $table->char('idTestimony', 13)->primary();
            $table->text('description');
            $table->string('firstName', 200);
            $table->string('surName', 200);
            $table->string('academic_level', 100);
            $table->string('place_origin', 200);
            $table->boolean('is_public');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ttestimony');
    }
}
