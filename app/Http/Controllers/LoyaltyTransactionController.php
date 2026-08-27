<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyTransaction;
use Illuminate\Http\Request;

class LoyaltyTransactionController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $transactions = LoyaltyTransaction::with([
            'customer',
            'membership.loyaltyPlan',
            'processedBy',
        ])
        ->when($search !== '', function ($query) use ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('id', $search)
                    ->orWhereHas('customer', function ($query) use ($search) {
                        $query->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('membership', function ($query) use ($search) {
                        $query->where('membership_code', 'like', "%{$search}%");
                    })
                    ->orWhereHas('processedBy', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    });
            });
        })
        ->latest('transaction_date')
        ->get();

        return view('transactions.index', compact('transactions', 'search'));
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
