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
        // If table doesn't exist, create it
        if (!Schema::hasTable('chat_messages')) {
            Schema::create('chat_messages', function (Blueprint $table) {
                $table->id();
                $table->foreignId('chat_id')->constrained()->onDelete('cascade');
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->text('message');
                $table->timestamps();
            });
        } else {
            // If table exists, only add missing columns
            Schema::table('chat_messages', function (Blueprint $table) {
                if (!Schema::hasColumn('chat_messages', 'chat_id')) {
                    $table->foreignId('chat_id')->constrained()->onDelete('cascade');
                }

                if (!Schema::hasColumn('chat_messages', 'user_id')) {
                    $table->foreignId('user_id')->constrained()->onDelete('cascade');
                }

                if (!Schema::hasColumn('chat_messages', 'message')) {
                    $table->text('message');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
