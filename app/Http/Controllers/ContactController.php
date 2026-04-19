<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Services\LeadNotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct(private readonly LeadNotificationService $leadNotificationService)
    {
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:150'],
        ]);

        $contact = Contact::create($validated);

        $this->leadNotificationService->notify($contact);

        return response()->json(['message' => 'Спасибо! Мы свяжемся с вами в ближайшее время.']);
    }
}
