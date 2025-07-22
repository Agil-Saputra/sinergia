<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WhatsAppService;

class TestWhatsAppCommand extends Command
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
    protected $description = 'Test WhatsApp notification service';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $phone = $this->argument('phone');
        $message = $this->argument('message') ?? 'Test message from Sinergia application';

        $whatsappService = new WhatsAppService();
        
        // Format phone number
        $formattedPhone = $whatsappService->formatPhoneNumber($phone);
        
        if (!$formattedPhone) {
            $this->error('Invalid phone number format');
            return 1;
        }

        $this->info("Sending WhatsApp message to: {$formattedPhone}");
        $this->info("Message: {$message}");

        $result = $whatsappService->sendMessage($formattedPhone, $message);

        if ($result) {
            $this->info('✅ WhatsApp message sent successfully!');
            return 0;
        } else {
            $this->error('❌ Failed to send WhatsApp message');
            $this->error('Please check your Fonnte token and configuration');
            return 1;
        }
    }
}
