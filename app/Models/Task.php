<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'assigned_by',
        'title',
        'description',
        'priority',
        'status',
        'category',
        'estimated_time',
        'assigned_date',
        'started_at',
        'completed_at',
        'completion_notes',
        'proof_image'
    ];

    protected $casts = [
        'assigned_date' => 'date',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'estimated_time' => 'decimal:1'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            'high' => 'bg-red-100 text-red-800',
            'medium' => 'bg-blue-100 text-blue-800',
            'low' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'assigned' => 'bg-gray-100 text-gray-800',
            'in_progress' => 'bg-yellow-100 text-yellow-800',
            'completed' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getStatusTextAttribute(): string
    {
        return match($this->status) {
            'assigned' => '📋 Ditugaskan',
            'in_progress' => '⚡ Sedang Dikerjakan',
            'completed' => '✅ Selesai',
            default => 'Unknown'
        };
    }

    // Start all assigned tasks for today when user checks in
    public static function startTodayTasks($userId)
    {
        return self::where('user_id', $userId)
            ->where('status', 'assigned')
            ->where('assigned_date', today())
            ->update([
                'status' => 'in_progress',
                'started_at' => now()
            ]);
    }
}
