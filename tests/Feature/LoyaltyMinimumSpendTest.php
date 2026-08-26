<?php

use App\Models\Customer;
use App\Models\LoyaltyMembership;
use App\Models\LoyaltyPlan;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Str;

function staffUser(): User
{
    return User::factory()->create([
        'role' => 'staff',
    ]);
}

function activeMembershipWithMinimumSpend(float $minimumSpend): array
{
    $plan = LoyaltyPlan::create([
        'name' => 'Minimum Spend Plan',
        'price' => 1000,
        'discount_percentage' => 10,
        'minimum_spend' => $minimumSpend,
        'validity_months' => 12,
        'is_active' => true,
    ]);

    $customer = Customer::create([
        'first_name' => 'Test',
        'last_name' => 'Customer',
        'phone' => '09123456789',
    ]);

    $membership = LoyaltyMembership::create([
        'customer_id' => $customer->id,
        'loyalty_plan_id' => $plan->id,
        'membership_code' => 'MM-' . strtoupper(Str::random(8)),
        'qr_token' => (string) Str::uuid(),
        'activated_at' => now(),
        'expires_at' => now()->addYear(),
        'status' => 'active',
    ]);

    return [$plan, $customer, $membership];
}

test('scanner does not apply discount below loyalty plan minimum spend', function () {
    $user = staffUser();
    [, , $membership] = activeMembershipWithMinimumSpend(500);

    $service = Service::create([
        'name' => 'Quick Service',
        'price' => 350,
        'discount_eligible' => true,
        'is_active' => true,
    ]);

    $this->actingAs($user)
        ->post(route('scanner.confirm'), [
            'membership_id' => $membership->id,
            'services' => [$service->id],
        ])
        ->assertRedirect(route('scanner.index'));

    $transaction = \App\Models\LoyaltyTransaction::first();

    expect($transaction->subtotal)->toBe('350.00')
        ->and($transaction->eligible_subtotal)->toBe('350.00')
        ->and($transaction->discount_amount)->toBe('0.00')
        ->and($transaction->total_amount)->toBe('350.00')
        ->and($transaction->items()->first()->discount_amount)->toBe('0.00');
});

test('scanner applies discount when eligible subtotal reaches minimum spend', function () {
    $user = staffUser();
    [, , $membership] = activeMembershipWithMinimumSpend(500);

    $service = Service::create([
        'name' => 'Premium Service',
        'price' => 500,
        'discount_eligible' => true,
        'is_active' => true,
    ]);

    $this->actingAs($user)
        ->post(route('scanner.confirm'), [
            'membership_id' => $membership->id,
            'services' => [$service->id],
        ])
        ->assertRedirect(route('scanner.index'));

    $transaction = \App\Models\LoyaltyTransaction::first();

    expect($transaction->subtotal)->toBe('500.00')
        ->and($transaction->eligible_subtotal)->toBe('500.00')
        ->and($transaction->discount_amount)->toBe('50.00')
        ->and($transaction->total_amount)->toBe('450.00')
        ->and($transaction->items()->first()->discount_amount)->toBe('50.00');
});

test('scanner uses entered amount for variable price services', function () {
    $user = staffUser();
    [, , $membership] = activeMembershipWithMinimumSpend(500);

    $service = Service::create([
        'name' => 'Custom Service',
        'price' => 0,
        'discount_eligible' => true,
        'is_active' => true,
    ]);

    $this->actingAs($user)
        ->post(route('scanner.confirm'), [
            'membership_id' => $membership->id,
            'services' => [$service->id],
            'custom_prices' => [
                $service->id => 800,
            ],
        ])
        ->assertRedirect(route('scanner.index'));

    $transaction = \App\Models\LoyaltyTransaction::first();
    $item = $transaction->items()->first();

    expect($transaction->subtotal)->toBe('800.00')
        ->and($transaction->eligible_subtotal)->toBe('800.00')
        ->and($transaction->discount_amount)->toBe('80.00')
        ->and($transaction->total_amount)->toBe('720.00')
        ->and($item->original_price)->toBe('800.00')
        ->and($item->final_price)->toBe('720.00');
});
