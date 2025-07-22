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
        Schema::table('users', function (Blueprint $table) {
            // Check if columns exist before dropping them
            if (Schema::hasColumn('users', 'qr_token')) {
                $table->dropColumn('qr_token');
            }
            if (Schema::hasColumn('users', 'qr_generated_at')) {
                $table->dropColumn('qr_generated_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('qr_token')->nullable()->unique()->after('employee_code');
            $table->timestamp('qr_generated_at')->nullable()->after('qr_token');
        });
    }
};
