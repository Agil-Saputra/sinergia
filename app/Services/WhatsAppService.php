<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    private $token;
    private $apiUrl;

    public function __construct()
    {
        $this->token = config('services.fonnte.token');
        $this->apiUrl = config('services.fonnte.url', 'https://api.fonnte.com/send');
    }

    /**
     * Send WhatsApp message using Fonnte API
     */
    public function sendMessage($target, $message)
    {
        if (empty($this->token)) {
            Log::error('Fonnte token not configured');
            return false;
        }

        if (empty($target) || empty($message)) {
            Log::error('Target or message is empty');
            return false;
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $target,
                'message' => $message,
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $this->token
            ),
        ));

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            Log::error('WhatsApp API Error: ' . $error);
            curl_close($curl);
            return false;
        }

        curl_close($curl);

        // Log response for debugging
        Log::info('WhatsApp API Response: ' . $response);

        return $httpCode === 200;
    }

    /**
     * Notify supervisor when employee creates a task
     */
    public function notifyTaskCreated($task, $supervisorPhone)
    {
        $message = "🆕 *TUGAS BARU DIBUAT*\n\n";
        $message .= "📝 *Judul:* {$task->title}\n";
        $message .= "👤 *Dibuat oleh:* {$task->user->name}\n";
        $message .= "⚡ *Prioritas:* " . ucfirst($task->priority) . "\n";
        $message .= "📅 *Tanggal:* " . $task->assigned_date->format('d/m/Y') . "\n";
        $message .= "📋 *Deskripsi:* {$task->description}\n\n";
        $message .= "Silakan cek dashboard admin untuk memberikan feedback.";

        return $this->sendMessage($supervisorPhone, $message);
    }

    /**
     * Notify employee when task is assigned by supervisor
     */
    public function notifyTaskAssigned($task, $employeePhone)
    {
        $message = "📋 *TUGAS BARU UNTUK ANDA*\n\n";
        $message .= "📝 *Judul:* {$task->title}\n";
        $message .= "👔 *Dari:* {$task->assignedBy->name}\n";
        $message .= "⚡ *Prioritas:* " . ucfirst($task->priority) . "\n";
        $message .= "📅 *Deadline:* " . ($task->due_date ? $task->due_date->format('d/m/Y') : 'Tidak ada') . "\n";
        
        if ($task->estimated_time) {
            $message .= "⏱️ *Estimasi:* {$task->estimated_time} jam\n";
        }
        
        $message .= "📋 *Deskripsi:* {$task->description}\n\n";
        
        if ($task->notes) {
            $message .= "📝 *Catatan:* {$task->notes}\n\n";
        }
        
        $message .= "Silakan buka aplikasi Sinergia untuk mulai mengerjakan tugas.";

        return $this->sendMessage($employeePhone, $message);
    }

    /**
     * Notify employee when supervisor gives feedback
     */
    public function notifyFeedbackGiven($task, $employeePhone)
    {
        $feedbackEmoji = [
            'excellent' => '🌟',
            'good' => '👍',
            'needs_improvement' => '⚠️'
        ];

        $feedbackText = [
            'excellent' => 'Sangat Baik',
            'good' => 'Baik',
            'needs_improvement' => 'Perlu Perbaikan'
        ];

        $emoji = $feedbackEmoji[$task->feedback_type] ?? '📝';
        $feedback = $feedbackText[$task->feedback_type] ?? 'Tidak diketahui';

        $message = "{$emoji} *FEEDBACK TUGAS*\n\n";
        $message .= "📝 *Tugas:* {$task->title}\n";
        $message .= "📊 *Penilaian:* {$feedback}\n";
        
        if ($task->admin_feedback) {
            $message .= "💬 *Catatan:* {$task->admin_feedback}\n";
        }
        
        if ($task->feedback_type === 'needs_improvement') {
            $message .= "\n⚠️ *Perhatian:* Tugas ini memerlukan perbaikan. Silakan lakukan perbaikan yang diperlukan dan tandai sebagai selesai di aplikasi.";
        } else {
            $message .= "\n✅ Terima kasih atas kerja keras Anda!";
        }

        return $this->sendMessage($employeePhone, $message);
    }

    /**
     * Notify supervisor when employee completes correction
     */
    public function notifyCorrectionCompleted($task, $supervisorPhone)
    {
        $message = "✅ *PERBAIKAN SELESAI*\n\n";
        $message .= "📝 *Tugas:* {$task->title}\n";
        $message .= "👤 *Karyawan:* {$task->user->name}\n";
        $message .= "📅 *Perbaikan selesai:* " . $task->correction_completed_at->format('d/m/Y H:i') . "\n\n";
        $message .= "Karyawan telah menyelesaikan perbaikan yang diminta. Silakan cek kembali di dashboard admin.";

        return $this->sendMessage($supervisorPhone, $message);
    }

    /**
     * Notify supervisor about emergency report
     */
    public function notifyEmergencyReport($report, $supervisorPhone)
    {
        $priorityEmoji = [
            'low' => '🟢',
            'medium' => '🟡',
            'high' => '🔴',
            'critical' => '🚨'
        ];

        $priorityText = [
            'low' => 'Rendah',
            'medium' => 'Sedang', 
            'high' => 'Tinggi',
            'critical' => 'Kritis'
        ];

        $emoji = $priorityEmoji[$report->priority] ?? '📢';
        $priority = $priorityText[$report->priority] ?? 'Tidak diketahui';

        $message = "🚨 *LAPORAN DARURAT*\n\n";
        $message .= "📝 *Judul:* {$report->title}\n";
        $message .= "👤 *Pelapor:* {$report->user->name}\n";
        $message .= "{$emoji} *Prioritas:* {$priority}\n";
        
        if ($report->location) {
            $message .= "📍 *Lokasi:* {$report->location}\n";
        }
        
        $message .= "📋 *Deskripsi:* {$report->description}\n";
        $message .= "📅 *Waktu:* " . $report->created_at->format('d/m/Y H:i') . "\n\n";
        
        if ($report->priority === 'critical' || $report->priority === 'high') {
            $message .= "⚠️ *PERHATIAN:* Laporan ini memerlukan tindakan segera!";
        } else {
            $message .= "Silakan cek dashboard admin untuk menindaklanjuti laporan ini.";
        }

        return $this->sendMessage($supervisorPhone, $message);
    }

    /**
     * Get supervisor phone number from config
     */
    public function getSupervisorPhone()
    {
        return config('emergency.supervisor_phone');
    }

    /**
     * Format phone number for WhatsApp (remove + and spaces)
     */
    public function formatPhoneNumber($phone)
    {
        if (empty($phone)) {
            return null;
        }

        // Remove +, spaces, and dashes
        $formatted = preg_replace('/[\+\s\-]/', '', $phone);
        
        // Ensure it starts with country code (62 for Indonesia)
        if (substr($formatted, 0, 1) === '0') {
            $formatted = '62' . substr($formatted, 1);
        } elseif (substr($formatted, 0, 2) !== '62') {
            $formatted = '62' . $formatted;
        }

        return $formatted;
    }
}
