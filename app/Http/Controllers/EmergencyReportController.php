<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EmergencyReport;

class EmergencyReportController extends Controller
{
    /**
     * Display emergency reports for the user
     */
    public function index()
    {
        if (!Auth::check() || !Auth::user()->isUser()) {
            return redirect('/login')->with('error', 'Access denied. User only.');
        }
        
        $reports = EmergencyReport::forUser(Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('user.emergency-reports', compact('reports'));
    }

    /**
     * Store a new emergency report
     */
    public function store(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isUser()) {
            return redirect('/login')->with('error', 'Access denied. User only.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'priority' => 'required|in:low,medium,high,critical',
            'location' => 'nullable|string|max:255',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,mp4,avi,mov,pdf,doc,docx|max:10240', // 10MB max
        ]);

        try {
            $attachments = [];
            
            // Handle file upload
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('emergency-reports', $filename, 'public');
                $attachments[] = $path;
            }
            EmergencyReport::create([
                'user_id' => Auth::id(),
                'title' => $validated['title'],
                'description' => $validated['description'],
                'priority' => $validated['priority'],
                'location' => $validated['location'] ?? null,
                'attachments' => $attachments,
                'status' => 'pending',
                'reported_at' => now(),
            ]);

            return redirect()->route('user.emergency-reports')
                ->with('success', 'Emergency report submitted successfully! We will review it shortly.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to submit emergency report. Please try again.');
        }
    }

    /**
     * Display a specific emergency report
     */
    public function show($id)
    {
        if (!Auth::check() || !Auth::user()->isUser()) {
            return redirect('/login')->with('error', 'Access denied. User only.');
        }

        $report = EmergencyReport::forUser(Auth::id())->findOrFail($id);
        
        return view('user.emergency-report-detail', compact('report'));
    }

    /**
     * Get statistics for emergency reports
     */
    public function getStats()
    {
        $userId = Auth::id();
        
        return [
            'total' => EmergencyReport::forUser($userId)->count(),
            'pending' => EmergencyReport::forUser($userId)->where('status', 'pending')->count(),
            'under_review' => EmergencyReport::forUser($userId)->where('status', 'under_review')->count(),
            'resolved' => EmergencyReport::forUser($userId)->where('status', 'resolved')->count(),
            'closed' => EmergencyReport::forUser($userId)->where('status', 'closed')->count(),
        ];
    }
}
