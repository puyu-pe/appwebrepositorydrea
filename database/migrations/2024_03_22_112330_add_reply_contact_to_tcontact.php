<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReplyContactToTcontact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tcontact', function (Blueprint $table) {
            $table->text('replyContact')->nullable()->after('messageContact');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tcontact', function (Blueprint $table) {
            $table->dropColumn('replyContact');
        });
    }
}
