<?php

use App\Models\Customer;
use App\Models\LoyaltyMembership;
use App\Models\LoyaltyPlan;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Str;

function managementUser(): User
{
    return User::factory()->create([
        'role' => 'management',
    ]);
}

test('customer show and edit pages render', function () {
    $user = managementUser();

    $plan = LoyaltyPlan::create([
        'name' => 'Classic Plan',
        'price' => 1000,
        'discount_percentage' => 10,
        'validity_months' => 12,
        'is_active' => true,
    ]);

    $customer = Customer::create([
        'first_name' => 'Maria',
        'last_name' => 'Santos',
        'phone' => '09123456789',
    ]);

    LoyaltyMembership::create([
        'customer_id' => $customer->id,
        'loyalty_plan_id' => $plan->id,
        'membership_code' => 'MM-TEST-0001',
        'qr_token' => (string) Str::uuid(),
        'activated_at' => now(),
        'expires_at' => now()->addYear(),
        'status' => 'active',
    ]);

    $this->actingAs($user)
        ->get(route('customers.show', $customer))
        ->assertOk()
        ->assertSee('Maria')
        ->assertSee('MM-TEST-0001');

    $this->actingAs($user)
        ->get(route('customers.edit', $customer))
        ->assertOk()
        ->assertSee('Edit Customer')
        ->assertSee('09123456789');
});

test('customer edit page updates customer details', function () {
    $user = managementUser();

    $customer = Customer::create([
        'first_name' => 'Maria',
        'last_name' => 'Santos',
        'phone' => '09123456789',
    ]);

    $this->actingAs($user)
        ->put(route('customers.update', $customer), [
            'first_name' => 'Ana',
            'last_name' => 'Reyes',
            'phone' => '09998887777',
            'birth_date' => '1995-05-10',
        ])
        ->assertRedirect(route('customers.index'));

    $customer->refresh();

    expect($customer->first_name)->toBe('Ana')
        ->and($customer->last_name)->toBe('Reyes')
        ->and($customer->phone)->toBe('09998887777');
});

test('service show and edit pages render', function () {
    $user = managementUser();

    $service = Service::create([
        'name' => 'Classic Manicure',
        'price' => 500,
        'discount_eligible' => true,
        'is_active' => true,
    ]);

    $this->actingAs($user)
        ->get(route('services.show', $service))
        ->assertOk()
        ->assertSee('Classic Manicure')
        ->assertSee('PHP 500.00');

    $this->actingAs($user)
        ->get(route('services.edit', $service))
        ->assertOk()
        ->assertSee('Edit Service')
        ->assertSee('Classic Manicure');
});

test('loyalty plan show and edit pages render', function () {
    $user = managementUser();

    $plan = LoyaltyPlan::create([
        'name' => 'Gold Plan',
        'price' => 1500,
        'discount_percentage' => 15,
        'validity_months' => 12,
        'is_active' => true,
    ]);

    $this->actingAs($user)
        ->get(route('loyalty-plans.show', $plan))
        ->assertOk()
        ->assertSee('Gold Plan')
        ->assertSee('15.00%');

    $this->actingAs($user)
        ->get(route('loyalty-plans.edit', $plan))
        ->assertOk()
        ->assertSee('Edit Loyalty Plan')
        ->assertSee('Gold Plan');
});

test('membership show displays linked customer account email', function () {
    $user = managementUser();

    $customerUser = User::factory()->create([
        'email' => 'customer@example.com',
        'role' => 'customer',
    ]);

    $plan = LoyaltyPlan::create([
        'name' => 'Classic Plan',
        'price' => 1000,
        'discount_percentage' => 10,
        'validity_months' => 12,
        'is_active' => true,
    ]);

    $customer = Customer::create([
        'user_id' => $customerUser->id,
        'first_name' => 'Maria',
        'last_name' => 'Santos',
        'phone' => '09123456789',
    ]);

    $membership = LoyaltyMembership::create([
        'customer_id' => $customer->id,
        'loyalty_plan_id' => $plan->id,
        'membership_code' => 'MM-TEST-0002',
        'qr_token' => (string) Str::uuid(),
        'activated_at' => now(),
        'expires_at' => now()->addYear(),
        'status' => 'active',
    ]);

    $this->actingAs($user)
        ->get(route('memberships.show', $membership))
        ->assertOk()
        ->assertSee('customer@example.com')
        ->assertSee('MM-TEST-0002');
});

test('user management index handles users without timestamps', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $legacyUser = User::factory()->create([
        'name' => 'Legacy Staff',
        'role' => 'staff',
    ]);

    $legacyUser->timestamps = false;
    $legacyUser->created_at = null;
    $legacyUser->updated_at = null;
    $legacyUser->save();

    $this->actingAs($admin)
        ->get(route('users.index'))
        ->assertOk()
        ->assertSee('Legacy Staff')
        ->assertSee('Not recorded');
});
