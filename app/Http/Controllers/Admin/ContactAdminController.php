<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ContactAdminController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Contacts', [
            'contacts' => Contact::latest()->get(),
        ]);
    }

    public function markRead(Contact $contact): RedirectResponse
    {
        $contact->update(['is_read' => true]);

        return redirect()->route('admin.contacts')->with('success', 'Отмечено как прочитанное.');
    }

    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()->route('admin.contacts')->with('success', 'Заявка удалена.');
    }
}
