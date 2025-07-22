<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Tipe task: routine (dibuat admin) atau incidental (dibuat karyawan)
            $table->enum('task_type', ['routine', 'incidental'])->default('routine')->after('category');
            
            // Status approval untuk task insidental
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->nullable()->after('task_type');
            
            // Admin yang approve/reject
            $table->unsignedBigInteger('approved_by')->nullable()->after('approval_status');
            
            // Tanggal approval
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            
            // Keterangan rejection
            $table->text('rejection_reason')->nullable()->after('approved_at');
            
            // Flag untuk task yang dibuat sendiri oleh karyawan
            $table->boolean('is_self_assigned')->default(false)->after('rejection_reason');
            
            // Foreign key
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn([
                'task_type', 
                'approval_status', 
                'approved_by', 
                'approved_at', 
                'rejection_reason',
                'is_self_assigned'
            ]);
        });
    }
};
