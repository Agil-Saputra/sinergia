<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with(['user', 'feedbackBy']);
        
        // Filter berdasarkan employee created
        if ($request->has('filter') && $request->filter !== 'all') {
            if ($request->filter === 'employee_created') {
                $query->where('is_self_assigned', true);
            } elseif ($request->filter === 'needs_correction') {
                // Filter untuk task yang memerlukan perbaikan
                $query->where('feedback_type', 'needs_improvement')
                      ->where('correction_needed', true);
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

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->user_id,
            'assigned_by' => Auth::id(),
            'priority' => $request->priority,
            'category' => $request->category,
            'task_type' => 'routine', // Admin created tasks are routine
            'estimated_time' => $request->estimated_time,
            'due_date' => $request->due_date,
            'notes' => $request->notes,
            'assigned_date' => now()->format('Y-m-d'),
            'status' => 'assigned'
        ]);

        // Send WhatsApp notification to assigned employee
        $whatsappService = new WhatsAppService();
        $employee = User::find($request->user_id);
        if ($employee && $employee->phone_number) {
            $formattedPhone = $whatsappService->formatPhoneNumber($employee->phone_number);
            if ($formattedPhone) {
                $whatsappService->notifyTaskAssigned($task->load(['assignedBy', 'user']), $formattedPhone);
            }
        }

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

    public function giveFeedback(Request $request, Task $task)
    {
        $request->validate([
            'feedback_type' => 'required|in:excellent,good,needs_improvement',
            'admin_feedback' => 'nullable|string|max:1000'
        ]);

        $updateData = [
            'feedback_type' => $request->feedback_type,
            'admin_feedback' => $request->admin_feedback,
            'feedback_by' => Auth::id(),
            'feedback_at' => now()
        ];

        // If feedback is needs_improvement, mark that correction is needed
        if ($request->feedback_type === 'needs_improvement') {
            $updateData['correction_needed'] = true;
            $updateData['correction_completed_at'] = null; // Reset if previously completed
        } else {
            $updateData['correction_needed'] = false;
            $updateData['correction_completed_at'] = null;
        }

        $task->update($updateData);

        // Send WhatsApp notification to employee
        $whatsappService = new WhatsAppService();
        $employee = $task->user;
        if ($employee && $employee->phone_number) {
            $formattedPhone = $whatsappService->formatPhoneNumber($employee->phone_number);
            if ($formattedPhone) {
                $whatsappService->notifyFeedbackGiven($task, $formattedPhone);
            }
        }

        $message = $request->feedback_type === 'needs_improvement' 
            ? 'Feedback berhasil diberikan! Karyawan akan melihat bahwa perbaikan diperlukan.'
            : 'Feedback berhasil diberikan!';

        return redirect()->back()->with('success', $message);
    }
}
