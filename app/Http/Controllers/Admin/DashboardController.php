<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Tariff;
use App\Models\Review;
use App\Models\Result;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'tariffs'       => Tariff::count(),
                'reviews'       => Review::count(),
                'results'       => Result::count(),
                'contacts'      => Contact::count(),
                'new_contacts'  => Contact::where('is_read', false)->count(),
            ],
        ]);
    }
}
