<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddCodeGradeToTgradeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tgrade', function (Blueprint $table) {
            $table->string('codeGrade', 10)->nullable()->after('numberGrade');
        });

        Schema::table('tgrade', function (Blueprint $table) {
            $table->string('descriptionGrade', 50)->after('nameGrade');
        });

        DB::statement('UPDATE tgrade SET descriptionGrade = CAST(numberGrade AS CHAR(50))');

        Schema::table('tgrade', function (Blueprint $table) {
            $table->string('descriptionGrade', 50)->nullable(false)->change();
        });

        Schema::table('tgrade', function (Blueprint $table) {
            $table->dropColumn('numberGrade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tgrade', function (Blueprint $table) {
            $table->dropColumn('codeGrade');
        });

        Schema::table('tgrade', function (Blueprint $table) {
            $table->integer('numberGrade')->after('nameGrade');
        });

        DB::statement('UPDATE tgrade SET numberGrade = CAST(descriptionGrade AS SIGNED)');

        Schema::table('tgrade', function (Blueprint $table) {
            $table->dropColumn('descriptionGrade');
        });
    }
}
