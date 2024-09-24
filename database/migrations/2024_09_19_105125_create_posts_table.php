<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('body');
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('community_id')->nullable()->constrained()->onDelete('set null');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
     public function down(): void
{
    Schema::table('votes', function (Blueprint $table) {
        // Drop foreign key constraints if needed
        $table->dropForeign(['post_id']);
        $table->dropForeign(['comment_id']);
    });

    Schema::dropIfExists('posts');
    Schema::dropIfExists('votes');
}

};
