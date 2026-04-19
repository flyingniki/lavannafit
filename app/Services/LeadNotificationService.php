<?php

namespace App\Services;

use App\Mail\NewLeadSubmittedMail;
use App\Models\Contact;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LeadNotificationService
{
    public function notify(Contact $contact): void
    {
        $this->notifyByEmail($contact);
        $this->notifyByTelegram($contact);
    }

    private function notifyByEmail(Contact $contact): void
    {
        if (!config('services.lead_notifications.send_email')) {
            return;
        }

        $trainerEmail = (string) config('services.lead_notifications.trainer_email');
        if ($trainerEmail === '') {
            return;
        }

        try {
            Mail::to($trainerEmail)->send(new NewLeadSubmittedMail($contact));
        } catch (\Throwable $exception) {
            Log::warning('Lead email notification failed', [
                'contact_id' => $contact->id,
                'error' => $exception->getMessage(),
            ]);
        }
    }

    private function notifyByTelegram(Contact $contact): void
    {
        if (!config('services.lead_notifications.send_telegram')) {
            return;
        }

        $botToken = (string) config('services.telegram.bot_token');
        $chatId = (string) config('services.telegram.chat_id');

        if ($botToken === '' || $chatId === '') {
            return;
        }

        $text = $this->buildTelegramMessage($contact);

        try {
            $response = Http::asForm()->post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'HTML',
                'disable_web_page_preview' => true,
            ]);

            if ($response->failed()) {
                Log::warning('Lead telegram notification failed', [
                    'contact_id' => $contact->id,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }
        } catch (\Throwable $exception) {
            Log::warning('Lead telegram notification exception', [
                'contact_id' => $contact->id,
                'error' => $exception->getMessage(),
            ]);
        }
    }

    private function buildTelegramMessage(Contact $contact): string
    {
        $name = htmlspecialchars($contact->name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $phone = htmlspecialchars($contact->phone, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $email = $contact->email
            ? htmlspecialchars($contact->email, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
            : 'не указан';

        return "<b>Новая заявка с сайта</b>\n"
            . "Имя: {$name}\n"
            . "Телефон: {$phone}\n"
            . "Email: {$email}";
    }
}
