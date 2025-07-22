<?php

namespace App\Traits;

use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Log;

trait SendsWhatsAppNotifications
{
    /**
     * Send WhatsApp notification with error handling
     */
    protected function sendWhatsAppNotification($phone, $message, $context = '')
    {
        try {
            if (empty($phone) || empty($message)) {
                Log::warning("WhatsApp notification skipped: Missing phone or message", [
                    'context' => $context,
                    'phone' => $phone ? 'provided' : 'missing',
                    'message' => $message ? 'provided' : 'missing'
                ]);
                return false;
            }

            $whatsappService = new WhatsAppService();
            $formattedPhone = $whatsappService->formatPhoneNumber($phone);
            
            if (!$formattedPhone) {
                Log::warning("WhatsApp notification skipped: Invalid phone format", [
                    'context' => $context,
                    'original_phone' => $phone
                ]);
                return false;
            }

            $result = $whatsappService->sendMessage($formattedPhone, $message);
            
            if ($result) {
                Log::info("WhatsApp notification sent successfully", [
                    'context' => $context,
                    'phone' => $formattedPhone
                ]);
            } else {
                Log::error("WhatsApp notification failed", [
                    'context' => $context,
                    'phone' => $formattedPhone
                ]);
            }

            return $result;
        } catch (\Exception $e) {
            Log::error("WhatsApp notification exception", [
                'context' => $context,
                'error' => $e->getMessage(),
                'phone' => $phone ?? 'unknown'
            ]);
            return false;
        }
    }

    /**
     * Send notification to supervisor
     */
    protected function notifySupervisor($message, $context = '')
    {
        $whatsappService = new WhatsAppService();
        $supervisorPhone = $whatsappService->getSupervisorPhone();
        
        return $this->sendWhatsAppNotification($supervisorPhone, $message, $context . ' - supervisor');
    }

    /**
     * Send notification to employee
     */
    protected function notifyEmployee($employeePhone, $message, $context = '')
    {
        return $this->sendWhatsAppNotification($employeePhone, $message, $context . ' - employee');
    }
}
