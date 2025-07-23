<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WhatsAppService;
use App\Models\EmergencyReport;
use App\Models\User;

class TestEmergencyWhatsApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:test-emergency {user_id} {status=resolved}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test WhatsApp notification for emergency report status update';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');
        $status = $this->argument('status');
        
        $user = User::find($userId);
        
        if (!$user) {
            $this->error("❌ User with ID {$userId} not found");
            return 1;
        }
        
        if (!$user->phone_number) {
            $this->error("❌ User {$user->name} has no phone number");
            return 1;
        }
        
        // Create a test emergency report
        $emergencyReport = new EmergencyReport([
            'user_id' => $user->id,
            'title' => 'Test Emergency Report - WhatsApp Notification',
            'description' => 'This is a test emergency report to test WhatsApp notifications.',
            'status' => $status,
            'priority' => 'medium',
            'location' => 'Test Location - Office Building',
            'admin_notes' => 'Test admin notes: This is a test notification to verify WhatsApp integration is working correctly.',
            'reported_at' => now(),
        ]);
        
        // Set the user relationship and timestamps for testing
        $emergencyReport->setRelation('user', $user);
        $emergencyReport->created_at = now();
        
        $this->info("Testing emergency WhatsApp notification...");
        $this->info("User: {$user->name} ({$user->employee_code})");
        $this->info("Phone: {$user->phone_number}");
        $this->info("Status: {$status}");
        
        $whatsappService = app(WhatsAppService::class);
        
        // Format phone number
        $formattedPhone = $whatsappService->formatPhoneNumber($user->phone_number);
        $this->info("Formatted phone: {$formattedPhone}");
        
        try {
            $success = $whatsappService->notifyEmergencyStatusUpdate(
                $emergencyReport, 
                $formattedPhone, 
                'pending' // old status
            );
            
            if ($success) {
                $this->info('✅ Test notification sent successfully!');
                $this->info('Check the WhatsApp number for the test message.');
                return 0;
            } else {
                $this->error('❌ Failed to send test notification');
                return 1;
            }
        } catch (\Exception $e) {
            $this->error('❌ Exception occurred: ' . $e->getMessage());
            return 1;
        }
    }
}
