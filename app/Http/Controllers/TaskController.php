<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Display the tasks page
     */
    public function index(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isUser()) {
            return redirect('/login')->with('error', 'Access denied. User only.');
        }
        
        $query = Auth::user()->tasks();
        
        // Filter berdasarkan status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan tipe task
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('task_type', $request->type);
        }
        
        // Prioritaskan task hari ini
        $tasks = $query->orderByRaw("CASE WHEN assigned_date = CURDATE() THEN 0 ELSE 1 END")
                      ->orderBy('priority', 'desc')
                      ->orderBy('assigned_date')
                      ->get();
        
        return view('user.tasks', compact('tasks'));
    }

    /**
     * Show create task form
     */
    public function create()
    {
        if (!Auth::check() || !Auth::user()->isUser()) {
            return redirect('/login')->with('error', 'Access denied. User only.');
        }
        
        return view('user.create-task');
    }

    /**
     * Store a new task
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'task_type' => 'required|in:routine,incidental',
            'assigned_date' => 'required|date|after_or_equal:today',
            'estimated_time' => 'nullable|numeric|min:0.5|max:100'
        ]);

        $task = Task::create([
            'user_id' => Auth::id(),
            'assigned_by' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'task_type' => $request->task_type, // Will always be 'incidental' from form
            'assigned_date' => $request->assigned_date, // Will always be today from form
            'estimated_time' => $request->estimated_time,
            'is_self_assigned' => true,
            'status' => 'assigned'
        ]);

        // Send WhatsApp notification to supervisor
        $whatsappService = new WhatsAppService();
        $supervisorPhone = $whatsappService->getSupervisorPhone();
        if ($supervisorPhone) {
            $formattedPhone = $whatsappService->formatPhoneNumber($supervisorPhone);
            if ($formattedPhone) {
                $whatsappService->notifyTaskCreated($task->load('user'), $formattedPhone);
            }
        }
        
        return redirect()->route('user.tasks')->with('success', 'Task insidental berhasil dibuat dan siap dikerjakan!');
    }

    /**
     * Start working on a task
     */
    public function start(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($task->status !== 'assigned') {
            return response()->json(['error' => 'Task sudah dimulai atau selesai'], 400);
        }

        $task->update([
            'status' => 'in_progress',
            'started_at' => now()
        ]);

        return response()->json(['success' => true, 'message' => 'Task berhasil dimulai!']);
    }

    /**
     * Complete task with proof
     */
    public function complete(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'completion_notes' => 'required|string|max:500',
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Upload bukti gambar
        $proofPath = $request->file('proof_image')->store('task-proofs', 'public');

        $task->update([
            'status' => 'completed',
            'completed_at' => now(),
            'completion_notes' => $request->completion_notes,
            'proof_image' => $proofPath
        ]);

        return redirect()->route('user.tasks')->with('success', 'Tugas berhasil diselesaikan pada jam ' . now()->format('H:i') . '!');
    }

    /**
     * Show task details
     */
    public function show(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        return view('user.task-detail', compact('task'));
    }

    /**
     * Mark correction as completed
     */
    public function markCorrectionCompleted(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$task->correction_needed || $task->correction_completed_at) {
            return redirect()->back()->with('error', 'Perbaikan tidak diperlukan atau sudah selesai.');
        }

        $task->update([
            'correction_completed_at' => now(),
            'correction_needed' => false
        ]);

        // Send WhatsApp notification to supervisor
        $whatsappService = new WhatsAppService();
        $supervisorPhone = $whatsappService->getSupervisorPhone();
        if ($supervisorPhone) {
            $formattedPhone = $whatsappService->formatPhoneNumber($supervisorPhone);
            if ($formattedPhone) {
                $whatsappService->notifyCorrectionCompleted($task->load('user'), $formattedPhone);
            }
        }

        return redirect()->back()->with('success', 'Perbaikan telah ditandai selesai! Supervisor akan melihat bahwa perbaikan telah dilakukan.');
    }
}
