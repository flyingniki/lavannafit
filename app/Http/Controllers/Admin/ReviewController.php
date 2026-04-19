<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ReviewController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Reviews', [
            'reviews' => Review::orderBy('sort_order')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:100'],
            'city'       => ['nullable', 'string', 'max:100'],
            'text'       => ['required', 'string', 'max:1000'],
            'sort_order' => ['integer'],
            'is_active'  => ['boolean'],
        ]);

        Review::create($data);

        return redirect()->route('admin.reviews')->with('success', 'Отзыв добавлен.');
    }

    public function update(Request $request, Review $review): RedirectResponse
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:100'],
            'city'       => ['nullable', 'string', 'max:100'],
            'text'       => ['required', 'string', 'max:1000'],
            'sort_order' => ['integer'],
            'is_active'  => ['boolean'],
        ]);

        $review->update($data);

        return redirect()->route('admin.reviews')->with('success', 'Отзыв обновлён.');
    }

    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();

        return redirect()->route('admin.reviews')->with('success', 'Отзыв удалён.');
    }
}
