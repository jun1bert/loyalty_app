<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyMembership;

class MembershipController extends Controller
{
    public function index()
    {
        $memberships = LoyaltyMembership::with([
            'customer',
            'loyaltyPlan',
        ])
        ->latest()
        ->get();

        return view('memberships.index', compact('memberships'));
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