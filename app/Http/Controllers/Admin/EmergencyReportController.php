<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmergencyReport;
use Illuminate\Http\Request;

class EmergencyReportController extends Controller
{
    public function index(Request $request)
    {
        $query = EmergencyReport::with('user');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by urgency
        if ($request->filled('urgency')) {
            $query->where('urgency', $request->urgency);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $reports = $query->latest()->paginate(20);

        return view('admin.emergency-reports.index', compact('reports'));
    }

    public function show(EmergencyReport $emergencyReport)
    {
        $emergencyReport->load('user');
        return view('admin.emergency-reports.show', compact('emergencyReport'));
    }

    public function updateStatus(Request $request, EmergencyReport $emergencyReport)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $emergencyReport->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'resolved_at' => $request->status === 'resolved' ? now() : null
        ]);

        return redirect()->back()->with('success', 'Emergency report status updated successfully!');
    }
}
