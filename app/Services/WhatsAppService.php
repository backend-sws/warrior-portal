<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Send a WhatsApp message (Placeholder for future API integration)
     *
     * @param string $mobileNumber The recipient's mobile number
     * @param string $message The message content
     * @return bool
     */
    public static function sendMessage(string $mobileNumber, string $message): bool
    {
        // TODO: Integrate actual WhatsApp API provider here (e.g. Twilio, Interakt)
        
        // For now, we log the message to simulate successful sending
        Log::info("WhatsApp Message simulated to {$mobileNumber}: {$message}");
        
        return true;
    }
}
