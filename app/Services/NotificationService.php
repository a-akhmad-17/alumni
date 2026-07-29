<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Send notification to Telegram Group/Admin/Koordinator
     */
    public static function sendTelegramNotification($message)
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');

        if (!empty($botToken) && !empty($chatId)) {
            try {
                Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                    'chat_id' => $chatId,
                    'text' => $message,
                    'parse_mode' => 'HTML',
                ]);
            } catch (\Exception $e) {
                Log::error('Telegram notification error: ' . $e->getMessage());
            }
        }
    }

    /**
     * Send notification to WhatsApp Gateway (Fonnte / Wablas / Ruangguru WA / etc.)
     */
    public static function sendWhatsAppNotification($targetNumber, $message)
    {
        $token = env('WA_GATEWAY_TOKEN');
        $url = env('WA_GATEWAY_URL', 'https://api.fonnte.com/send');

        if (!empty($token) && !empty($targetNumber)) {
            try {
                Http::withHeaders([
                    'Authorization' => $token,
                ])->post($url, [
                    'target' => $targetNumber,
                    'message' => $message,
                ]);
            } catch (\Exception $e) {
                Log::error('WhatsApp notification error: ' . $e->getMessage());
            }
        }
    }
}
