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
        Schema::table('chats', function (Blueprint $table) {
            // Add name column if it doesn't exist
            if (!Schema::hasColumn('chats', 'name')) {
                $table->string('name')->nullable()->after('id');
            }
            
            // Add is_group column if it doesn't exist
            if (!Schema::hasColumn('chats', 'is_group')) {
                $table->boolean('is_group')->default(false)->after('name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chats', function (Blueprint $table) {
            if (Schema::hasColumn('chats', 'name')) {
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('chats', 'is_group')) {
                $table->dropColumn('is_group');
            }
        });
    }
};