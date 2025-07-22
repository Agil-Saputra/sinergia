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
            $table->text('admin_feedback')->nullable()->after('proof_image');
            $table->enum('feedback_type', ['good', 'needs_improvement', 'excellent'])->nullable()->after('admin_feedback');
            $table->foreignId('feedback_by')->nullable()->after('feedback_type')->constrained('users')->onDelete('set null');
            $table->timestamp('feedback_at')->nullable()->after('feedback_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['feedback_by']);
            $table->dropColumn(['admin_feedback', 'feedback_type', 'feedback_by', 'feedback_at']);
        });
    }
};
