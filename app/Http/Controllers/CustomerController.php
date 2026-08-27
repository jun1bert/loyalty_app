<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\LoyaltyPlan;
use App\Models\LoyaltyMembership;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $customers = Customer::with([
            'loyaltyMembership.loyaltyPlan',
        ])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhereHas('loyaltyMembership', function ($query) use ($search) {
                            $query->where('membership_code', 'like', "%{$search}%");
                        })
                        ->orWhereHas('loyaltyMembership.loyaltyPlan', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->get();

        return view('customers.index', compact('customers', 'search'));
    }

    public function create()
    {
        $plans = LoyaltyPlan::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('customers.create', compact('plans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'birth_date' => 'nullable|date|before:today',
            'loyalty_plan_id' => 'required|exists:loyalty_plans,id',
        ]);

        $plan = LoyaltyPlan::where('id', $validated['loyalty_plan_id'])
            ->where('is_active', true)
            ->firstOrFail();

        DB::transaction(function () use ($validated, $plan) {

            $customer = Customer::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'] ?? null,
                'birth_date' => $validated['birth_date'] ?? null,
            ]);

            $activatedAt = now();

            LoyaltyMembership::create([
                'customer_id' => $customer->id,
                'loyalty_plan_id' => $plan->id,

                'membership_code' => $this->generateMembershipCode(),

                'qr_token' => Str::random(64),

                'activated_at' => $activatedAt,

                'expires_at' => $plan->validity_months
                    ? $activatedAt->copy()->addMonths($plan->validity_months)
                    : null,

                'status' => 'active',
            ]);
        });

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer and loyalty membership created successfully.');
    }

    public function show(Customer $customer)
    {
        $customer->load('loyaltyMembership.loyaltyPlan');

        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'birth_date' => 'nullable|date|before:today',
        ]);

        $customer->update($validated);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }

    private function generateMembershipCode()
    {
        do {
            $code = 'MM-' . strtoupper(Str::random(8));
        } while (
            LoyaltyMembership::where('membership_code', $code)->exists()
        );

        return $code;
    }
}
