<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WhatsAppService;

class TestWhatsApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:test {phone} {message?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test WhatsApp API connection and send a test message';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $whatsappService = app(WhatsAppService::class);
        
        $phone = $this->argument('phone');
        $message = $this->argument('message') ?? 'Test message from Sinergia system. If you receive this, WhatsApp integration is working correctly! 🎉';
        
        $this->info('Testing WhatsApp API...');
        $this->info("Phone: {$phone}");
        $this->info("Message: {$message}");
        
        // Format phone number
        $formattedPhone = $whatsappService->formatPhoneNumber($phone);
        $this->info("Formatted phone: {$formattedPhone}");
        
        // Check if token is configured
        $token = config('services.fonnte.token');
        if (empty($token)) {
            $this->error('❌ FONNTE_TOKEN not configured in .env file');
            $this->info('Please add FONNTE_TOKEN=your-token-here to your .env file');
            return 1;
        }
        
        $this->info('✅ Token configured');
        
        // Send test message
        $this->info('Sending test message...');
        
        try {
            $success = $whatsappService->sendMessage($formattedPhone, $message);
            
            if ($success) {
                $this->info('✅ Message sent successfully!');
                $this->info('Check the WhatsApp number for the test message.');
                return 0;
            } else {
                $this->error('❌ Failed to send message');
                $this->info('Check your Fonnte account balance and API status');
                return 1;
            }
        } catch (\Exception $e) {
            $this->error('❌ Exception occurred: ' . $e->getMessage());
            return 1;
        }
    }
}
