<?php

namespace App\Http\Controllers;

use App\Models\Task;
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
            'category' => 'nullable|string',
            'estimated_time' => 'nullable|numeric|min:0.5|max:100'
        ]);

        $task = Task::create([
            'user_id' => Auth::id(),
            'assigned_by' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'task_type' => $request->task_type,
            'assigned_date' => $request->assigned_date,
            'category' => $request->category,
            'estimated_time' => $request->estimated_time,
            'is_self_assigned' => true,
            // Task insidental butuh approval, task routine langsung approved
            'approval_status' => $request->task_type === 'incidental' ? 'pending' : 'approved',
            'status' => $request->task_type === 'incidental' ? 'assigned' : 'assigned'
        ]);
        
        $message = $request->task_type === 'incidental' 
            ? 'Tugas insidental berhasil dibuat! Menunggu persetujuan supervisor.' 
            : 'Tugas berhasil dibuat!';
            
        return redirect()->route('user.tasks')->with('success', $message);
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
}
