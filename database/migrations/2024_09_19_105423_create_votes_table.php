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
        if (!Schema::hasTable('votes')) {
            Schema::create('votes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('post_id')->nullable()->constrained()->onDelete('cascade');
                $table->foreignId('comment_id')->nullable()->constrained()->onDelete('cascade');
                $table->integer('value'); // 1 for upvote, -1 for downvote
                $table->timestamps();

                $table->unique(['user_id', 'post_id']); // Unique constraint for post votes
                $table->unique(['user_id', 'comment_id']); // Unique constraint for comment votes
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('votes')) {
            Schema::table('votes', function (Blueprint $table) {
                if (Schema::hasColumn('votes', 'post_id')) {
                    $table->dropForeign(['post_id']);
                }
                if (Schema::hasColumn('votes', 'comment_id')) {
                    $table->dropForeign(['comment_id']);
                }
            });

            Schema::dropIfExists('votes');
        }
    }
};
