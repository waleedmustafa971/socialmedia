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
            // $table->integer('value')->default(0); // Add value column with default value
        });
    }

    /**
     * Reverse the migrations.
     */
     public function down()
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->dropColumn('value');
        });
    }
};
