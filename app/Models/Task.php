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
        'task_type',
        'approval_status',
        'approved_by',
        'approved_at',
        'rejection_reason',
        'is_self_assigned',
        'estimated_time',
        'assigned_date',
        'due_date',
        'notes',
        'started_at',
        'completed_at',
        'completion_notes',
        'proof_image',
        'admin_feedback',
        'feedback_type',
        'feedback_by',
        'feedback_at'
    ];

    protected $casts = [
        'assigned_date' => 'date',
        'due_date' => 'date',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'feedback_at' => 'datetime',
        'approved_at' => 'datetime',
        'estimated_time' => 'decimal:1',
        'is_self_assigned' => 'boolean'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function feedbackBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'feedback_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
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

    public function getFeedbackTypeColorAttribute(): string
    {
        return match($this->feedback_type) {
            'excellent' => 'bg-green-100 text-green-800',
            'good' => 'bg-blue-100 text-blue-800',
            'needs_improvement' => 'bg-yellow-100 text-yellow-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getFeedbackTypeTextAttribute(): string
    {
        return match($this->feedback_type) {
            'excellent' => '⭐ Sempurna',
            'good' => '👍 Bagus',
            'needs_improvement' => '📝 Perlu Perbaikan',
            default => ''
        };
    }

    public function getTaskTypeTextAttribute(): string
    {
        return match($this->task_type) {
            'routine' => '🔄 Rutin',
            'incidental' => '⚡ Insidental',
            default => 'Unknown'
        };
    }

    public function getTaskTypeColorAttribute(): string
    {
        return match($this->task_type) {
            'routine' => 'bg-blue-100 text-blue-800',
            'incidental' => 'bg-purple-100 text-purple-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getApprovalStatusTextAttribute(): string
    {
        return match($this->approval_status) {
            'pending' => '⏳ Menunggu Persetujuan',
            'approved' => '✅ Disetujui',
            'rejected' => '❌ Ditolak',
            default => ''
        };
    }

    public function getApprovalStatusColorAttribute(): string
    {
        return match($this->approval_status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
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
