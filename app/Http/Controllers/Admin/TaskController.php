<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with(['user', 'feedbackBy', 'approvedBy']);
        
        // Filter berdasarkan approval status untuk task insidental
        if ($request->has('approval') && $request->approval !== 'all') {
            if ($request->approval === 'pending_approval') {
                $query->where('task_type', 'incidental')
                      ->where('approval_status', 'pending');
            } elseif ($request->approval === 'employee_created') {
                $query->where('is_self_assigned', true);
            }
        }
        
        // Filter berdasarkan tipe task
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('task_type', $request->type);
        }
        
        $tasks = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('admin.tasks.index', compact('tasks'));
    }

    public function create()
    {
        $employees = User::where('role', 'user')->orderBy('name')->get();
        return view('admin.tasks.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'priority' => 'required|in:low,medium,high',
            'category' => 'nullable|string|max:100',
            'estimated_time' => 'nullable|numeric|min:0.5|max:200',
            'due_date' => 'nullable|date|after_or_equal:today',
            'notes' => 'nullable|string|max:1000',
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->user_id,
            'assigned_by' => Auth::id(),
            'priority' => $request->priority,
            'category' => $request->category,
            'task_type' => 'routine', // Admin created tasks are routine
            'approval_status' => 'approved', // Admin tasks auto-approved
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'estimated_time' => $request->estimated_time,
            'due_date' => $request->due_date,
            'notes' => $request->notes,
            'assigned_date' => now()->format('Y-m-d'),
            'status' => 'assigned'
        ]);

        return redirect()->route('admin.tasks.index')->with('success', 'Task berhasil dibuat dan ditugaskan!');
    }

    public function show(Task $task)
    {
        $task->load(['user', 'assignedBy', 'feedbackBy']);
        return view('admin.tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $employees = User::where('role', 'user')->orderBy('name')->get();
        return view('admin.tasks.edit', compact('task', 'employees'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'priority' => 'required|in:low,medium,high',
            'category' => 'nullable|string|max:100',
            'estimated_time' => 'nullable|numeric|min:0.5|max:200',
            'due_date' => 'nullable|date|after_or_equal:today',
            'notes' => 'nullable|string|max:1000',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->user_id,
            'priority' => $request->priority,
            'category' => $request->category,
            'estimated_time' => $request->estimated_time,
            'due_date' => $request->due_date,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.tasks.index')->with('success', 'Task berhasil diperbarui!');
    }

    public function destroy(Task $task)
    {
        if ($task->status === 'completed') {
            return redirect()->route('admin.tasks.index')->with('error', 'Task yang sudah selesai tidak bisa dihapus!');
        }

        $task->delete();
        return redirect()->route('admin.tasks.index')->with('success', 'Task berhasil dihapus!');
    }

    /**
     * Approve task insidental
     */
    public function approve(Request $request, Task $task)
    {
        if ($task->task_type !== 'incidental' || $task->approval_status !== 'pending') {
            return response()->json(['error' => 'Task tidak memerlukan persetujuan'], 400);
        }

        $task->update([
            'approval_status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now()
        ]);

        return response()->json(['success' => 'Task berhasil disetujui']);
    }

    /**
     * Reject task insidental
     */
    public function reject(Request $request, Task $task)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        if ($task->task_type !== 'incidental' || $task->approval_status !== 'pending') {
            return response()->json(['error' => 'Task tidak memerlukan persetujuan'], 400);
        }

        $task->update([
            'approval_status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'rejection_reason' => $request->rejection_reason
        ]);

        return response()->json(['success' => 'Task berhasil ditolak']);
    }

    public function giveFeedback(Request $request, Task $task)
    {
        $request->validate([
            'feedback_type' => 'required|in:excellent,good,needs_improvement',
            'admin_feedback' => 'nullable|string|max:1000'
        ]);

        $task->update([
            'feedback_type' => $request->feedback_type,
            'admin_feedback' => $request->admin_feedback,
            'feedback_by' => Auth::id(),
            'feedback_at' => now()
        ]);

        return redirect()->back()->with('success', 'Feedback berhasil diberikan!');
    }
}
