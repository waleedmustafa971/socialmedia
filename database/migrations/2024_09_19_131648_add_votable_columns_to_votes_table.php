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
            $table->morphs('votable'); // Adds `votable_id` and `votable_type` columns
        });
    }

    /**
     * Reverse the migrations.
     */
     public function down()
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->dropMorphs('votable'); // Removes `votable_id` and `votable_type` columns
        });
    }
};
