<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tariff;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TariffController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Tariffs', [
            'tariffs' => Tariff::orderBy('sort_order')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'price'       => ['required', 'string', 'max:50'],
            'period'      => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:500'],
            'features'    => ['nullable', 'array'],
            'features.*'  => ['string', 'max:200'],
            'sort_order'  => ['integer'],
            'is_active'   => ['boolean'],
        ]);

        Tariff::create($data);

        return redirect()->route('admin.tariffs')->with('success', 'Тариф добавлен.');
    }

    public function update(Request $request, Tariff $tariff): RedirectResponse
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'price'       => ['required', 'string', 'max:50'],
            'period'      => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:500'],
            'features'    => ['nullable', 'array'],
            'features.*'  => ['string', 'max:200'],
            'sort_order'  => ['integer'],
            'is_active'   => ['boolean'],
        ]);

        $tariff->update($data);

        return redirect()->route('admin.tariffs')->with('success', 'Тариф обновлён.');
    }

    public function destroy(Tariff $tariff): RedirectResponse
    {
        $tariff->delete();

        return redirect()->route('admin.tariffs')->with('success', 'Тариф удалён.');
    }
}
