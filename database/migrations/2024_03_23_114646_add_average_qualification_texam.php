<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAverageQualificationTexam extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('texam', function (Blueprint $table) {
            $table->integer('rating_counter')->nullable()->after('view_counter')->default(0);
            $table->decimal('rating_average', 10, 2)->nullable()->after('rating_counter')->default(0);
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
            $table->dropColumn('rating_counter');
            $table->dropColumn('rating_average');
        });
    }
}
