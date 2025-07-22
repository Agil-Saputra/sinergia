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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('assigned_by')->nullable()->constrained('users')->onDelete('set null'); // supervisor yang assign
            $table->string('title');
            $table->text('description');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->enum('status', ['assigned', 'in_progress', 'completed'])->default('assigned');
            $table->string('category')->nullable();
            $table->decimal('estimated_time', 4, 1)->nullable();
            $table->date('assigned_date'); // tanggal task diassign
            $table->timestamp('started_at')->nullable(); // otomatis ketika absen
            $table->timestamp('completed_at')->nullable(); // jam selesai
            $table->text('completion_notes')->nullable();
            $table->string('proof_image')->nullable(); // untuk bukti penyelesaian task
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
