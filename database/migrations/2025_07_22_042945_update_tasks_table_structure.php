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
        Schema::table('tasks', function (Blueprint $table) {
            
            // Tambah kolom baru
            
            // Update enum status
            $table->dropColumn('status');
        });
        
        // Tambah kembali kolom status dengan enum yang baru
        Schema::table('tasks', function (Blueprint $table) {
            $table->enum('status', ['assigned', 'in_progress', 'completed'])->default('assigned')->after('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Kembalikan ke struktur asli
            $table->dropForeign(['assigned_by']);
            $table->dropColumn(['assigned_by', 'assigned_date', 'started_at']);
            $table->dropColumn('status');
            $table->date('due_date')->after('estimated_time');
        });
        
        Schema::table('tasks', function (Blueprint $table) {
            $table->enum('status', ['todo', 'in_progress', 'completed'])->default('todo')->after('priority');
        });
    }
};
