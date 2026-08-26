<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LoyaltyMembership;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\LoyaltyTransaction;

class CustomerAuthController extends Controller
{
    public function activate(Request $request)
    {
        $validated = $request->validate([
            'membership_code' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $membership = LoyaltyMembership::with('customer')
            ->where('membership_code', $validated['membership_code'])
            ->first();

        if (!$membership) {
            return response()->json([
                'message' => 'Invalid membership code.',
            ], 404);
        }

        $customer = $membership->customer;

        if (!$customer) {
            return response()->json([
                'message' => 'Customer record not found.',
            ], 404);
        }

        if ($membership->status !== 'active') {
            return response()->json([
                'message' => 'This membership is not active.',
            ], 403);
        }

        if (
            $membership->expires_at &&
            $membership->expires_at->isPast()
        ) {
            return response()->json([
                'message' => 'This membership has expired.',
            ], 403);
        }

        if ($customer->phone !== $validated['phone']) {
            return response()->json([
                'message' => 'The phone number does not match our records.',
            ], 422);
        }

        if ($customer->user_id) {
            return response()->json([
                'message' => 'This membership already has an activated account.',
            ], 409);
        }

        $user = DB::transaction(function () use ($validated, $customer) {

            $user = User::create([
                'name' => $customer->first_name . ' ' . $customer->last_name,
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'customer',
            ]);

            $customer->update([
                'user_id' => $user->id,
            ]);

            return $user;
        });

        $token = $user->createToken('customer-mobile')->plainTextToken;

        return response()->json([
            'message' => 'Account activated successfully.',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ], 201);
    }


    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validated['email'])
            ->where('role', 'customer')
            ->first();

        if (
            !$user ||
            !Hash::check($validated['password'], $user->password)
        ) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user->tokens()->delete();

        $token = $user->createToken('customer-mobile')->plainTextToken;

        return response()->json([
            'message' => 'Login successful.',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ]);
    }

    public function membership(Request $request)
{
    $user = $request->user();

    if ($user->role !== 'customer') {
        return response()->json([
            'message' => 'Unauthorized.',
        ], 403);
    }

    $customer = $user->customer()
        ->with('loyaltyMembership.loyaltyPlan')
        ->first();

    if (!$customer) {
        return response()->json([
            'message' => 'Customer profile not found.',
        ], 404);
    }

    $membership = $customer->loyaltyMembership;

    if (!$membership) {
        return response()->json([
            'message' => 'Loyalty membership not found.',
        ], 404);
    }

    return response()->json([
        'customer' => [
            'id' => $customer->id,
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'phone' => $customer->phone,
        ],

        'membership' => [
            'membership_code' => $membership->membership_code,
            'status' => $membership->status,
            'activated_at' => $membership->activated_at?->toISOString(),
            'expires_at' => $membership->expires_at?->toISOString(),
            'qr_token' => $membership->qr_token,

            'plan' => [
                'name' => $membership->loyaltyPlan?->name,
                'discount_percentage' =>
                    $membership->loyaltyPlan?->discount_percentage,
            ],
        ],
    ]);
}

public function transactions(Request $request)
{
    $user = $request->user();

    if ($user->role !== 'customer') {
        return response()->json([
            'message' => 'Unauthorized.',
        ], 403);
    }

    $customer = $user->customer;

    if (!$customer) {
        return response()->json([
            'message' => 'Customer profile not found.',
        ], 404);
    }

    $transactions = LoyaltyTransaction::with([
        'items'
    ])
        ->where('customer_id', $customer->id)
        ->latest('transaction_date')
        ->get();

    return response()->json([
        'transactions' => $transactions->map(function ($transaction) {

            return [
                'id' => $transaction->id,

                'transaction_date' =>
                    $transaction->transaction_date?->toISOString(),

                'subtotal' =>
                    $transaction->subtotal,

                'discount_percentage' =>
                    $transaction->discount_percentage,

                'discount_amount' =>
                    $transaction->discount_amount,

                'total_amount' =>
                    $transaction->total_amount,

                'items' => $transaction->items->map(function ($item) {
                    return [
                        'service_name' =>
                            $item->service_name,

                        'original_price' =>
                            $item->original_price,

                        'discount_eligible' =>
                            $item->discount_eligible,

                        'discount_amount' =>
                            $item->discount_amount,

                        'final_price' =>
                            $item->final_price,
                    ];
                }),
            ];
        }),
    ]);
}
}