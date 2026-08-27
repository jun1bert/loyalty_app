<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyMembership;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $memberships = LoyaltyMembership::with([
            'customer',
            'loyaltyPlan',
        ])
        ->when($search !== '', function ($query) use ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('membership_code', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($query) use ($search) {
                        $query->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    })
                    ->orWhereHas('loyaltyPlan', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    });
            });
        })
        ->latest()
        ->get();

        return view('memberships.index', compact('memberships', 'search'));
    }

    public function show(LoyaltyMembership $membership)
    {
        $membership->load([
            'customer',
            'loyaltyPlan',
        ]);

        return view('memberships.show', compact('membership'));
    }
}
