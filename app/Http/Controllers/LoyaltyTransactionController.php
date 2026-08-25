<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyTransaction;

class LoyaltyTransactionController extends Controller
{
    public function index()
    {
        $transactions = LoyaltyTransaction::with([
            'customer',
            'membership.loyaltyPlan',
            'processedBy',
        ])
        ->latest('transaction_date')
        ->get();

        return view('transactions.index', compact('transactions'));
    }

    public function show(LoyaltyTransaction $transaction)
    {
        $transaction->load([
            'customer',
            'membership.loyaltyPlan',
            'processedBy',
            'items',
        ]);

        return view('transactions.show', compact('transaction'));
    }
}