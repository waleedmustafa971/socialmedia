<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up()
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->integer('type'); // 1 for upvote, -1 for downvote
        });
    }

    /**
     * Reverse the migrations.
     */
     public function down()
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
