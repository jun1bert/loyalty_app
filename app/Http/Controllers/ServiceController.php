<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $services = Service::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        return view('services.index', compact('services', 'search'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_eligible' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        Service::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'discount_eligible' => $request->boolean('discount_eligible'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('services.index')
            ->with('success', 'Service added successfully.');
    }

    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_eligible' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $service->update([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'discount_eligible' => $request->boolean('discount_eligible'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()
            ->route('services.index')
            ->with('success', 'Service deleted successfully.');
    }
}
