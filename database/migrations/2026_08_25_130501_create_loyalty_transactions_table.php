<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loyalty_transactions', function (Blueprint $table) {
    $table->id();

    $table->foreignId('customer_id')
        ->constrained()
        ->restrictOnDelete();

    $table->foreignId('loyalty_membership_id')
        ->constrained('loyalty_memberships')
        ->restrictOnDelete();

    $table->foreignId('processed_by')
        ->nullable()
        ->constrained('users')
        ->nullOnDelete();

    $table->decimal('subtotal', 10, 2);
    $table->decimal('eligible_subtotal', 10, 2);
    $table->decimal('discount_percentage', 5, 2);
    $table->decimal('discount_amount', 10, 2);
    $table->decimal('total_amount', 10, 2);

    $table->timestamp('transaction_date');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_transactions');
    }
};
