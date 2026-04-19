<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Result;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ResultController extends Controller
{
    public function index(): Response
    {
        $results = Result::orderBy('sort_order')->get()->map(function (Result $r) {
            return [
                'id'         => $r->id,
                'title'      => $r->title,
                'image_url'  => $r->image_path ? asset('storage/' . $r->image_path) : null,
                'sort_order' => $r->sort_order,
                'is_active'  => $r->is_active,
            ];
        });

        return Inertia::render('Admin/Results', [
            'results' => $results,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title'      => ['nullable', 'string', 'max:200'],
            'image'      => ['nullable', 'image', 'max:4096'],
            'sort_order' => ['integer'],
            'is_active'  => ['boolean'],
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('results', 'public');
        }

        Result::create([
            'title'      => $data['title'] ?? null,
            'image_path' => $path,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active'  => $data['is_active'] ?? true,
        ]);

        return redirect()->route('admin.results')->with('success', 'Слайд добавлен.');
    }

    public function update(Request $request, Result $result): RedirectResponse
    {
        $data = $request->validate([
            'title'      => ['nullable', 'string', 'max:200'],
            'image'      => ['nullable', 'image', 'max:4096'],
            'sort_order' => ['integer'],
            'is_active'  => ['boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($result->image_path) {
                Storage::disk('public')->delete($result->image_path);
            }
            $data['image_path'] = $request->file('image')->store('results', 'public');
        }

        $result->update([
            'title'      => $data['title'] ?? $result->title,
            'image_path' => $data['image_path'] ?? $result->image_path,
            'sort_order' => $data['sort_order'] ?? $result->sort_order,
            'is_active'  => $data['is_active'] ?? $result->is_active,
        ]);

        return redirect()->route('admin.results')->with('success', 'Слайд обновлён.');
    }

    public function destroy(Result $result): RedirectResponse
    {
        if ($result->image_path) {
            Storage::disk('public')->delete($result->image_path);
        }
        $result->delete();

        return redirect()->route('admin.results')->with('success', 'Слайд удалён.');
    }
}
