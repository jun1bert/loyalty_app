<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyPlan;
use Illuminate\Http\Request;

class LoyaltyPlanController extends Controller
{
    public function index()
    {
        $plans = LoyaltyPlan::latest()->get();

        return view('loyalty-plans.index', compact('plans'));
    }

    public function create()
    {
        return view('loyalty-plans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'validity_months' => 'required|integer|min:1|max:120',
        ]);

        LoyaltyPlan::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'discount_percentage' => $validated['discount_percentage'],
            'validity_months' => $validated['validity_months'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('loyalty-plans.index')
            ->with('success', 'Loyalty plan created successfully.');
    }

    public function show(LoyaltyPlan $loyaltyPlan)
    {
        return view('loyalty-plans.show', compact('loyaltyPlan'));
    }

    public function edit(LoyaltyPlan $loyaltyPlan)
    {
        return view('loyalty-plans.edit', compact('loyaltyPlan'));
    }

    public function update(Request $request, LoyaltyPlan $loyaltyPlan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'validity_months' => 'required|integer|min:1|max:120',
        ]);

        $loyaltyPlan->update([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'discount_percentage' => $validated['discount_percentage'],
            'validity_months' => $validated['validity_months'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('loyalty-plans.index')
            ->with('success', 'Loyalty plan updated successfully.');
    }

    public function destroy(LoyaltyPlan $loyaltyPlan)
    {
        $loyaltyPlan->delete();

        return redirect()
            ->route('loyalty-plans.index')
            ->with('success', 'Loyalty plan deleted successfully.');
    }
}