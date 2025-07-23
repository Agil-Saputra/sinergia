<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmergencyReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmergencyReportController extends Controller
{
    public function index(Request $request)
    {
        $query = EmergencyReport::with('user');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
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
            'status' => 'required|in:pending,under_review,resolved,closed',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        // Store old status for comparison
        $oldStatus = $emergencyReport->status;
        
        $emergencyReport->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'resolved_at' => $request->status === 'resolved' ? now() : null
        ]);

        // Send WhatsApp notification to user if status changed or notes added
        if ($oldStatus !== $request->status || $request->admin_notes) {
            try {
                $whatsappService = app(\App\Services\WhatsAppService::class);
                
                if ($emergencyReport->user->phone_number) {
                    $formattedPhone = $whatsappService->formatPhoneNumber($emergencyReport->user->phone_number);
                    $success = $whatsappService->notifyEmergencyStatusUpdate(
                        $emergencyReport, 
                        $formattedPhone, 
                        $oldStatus
                    );
                    
                    if ($success) {
                        Log::info("Emergency status update notification sent to user: {$emergencyReport->user->employee_code}");
                    } else {
                        Log::warning("Failed to send emergency status update notification to user: {$emergencyReport->user->employee_code}");
                    }
                } else {
                    Log::warning("User {$emergencyReport->user->employee_code} has no phone number for WhatsApp notification");
                }
            } catch (\Exception $e) {
                Log::error('Failed to send WhatsApp notification for emergency status update: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Status laporan darurat berhasil diperbarui dan notifikasi telah dikirim!');
    }
}
