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
        Schema::create('loyalty_transaction_items', function (Blueprint $table) {
    $table->id();

    $table->foreignId('loyalty_transaction_id')
        ->constrained('loyalty_transactions')
        ->cascadeOnDelete();

    $table->foreignId('service_id')
        ->nullable()
        ->constrained()
        ->nullOnDelete();

    $table->string('service_name');
    $table->decimal('original_price', 10, 2);
    $table->boolean('discount_eligible')->default(false);
    $table->decimal('discount_amount', 10, 2)->default(0);
    $table->decimal('final_price', 10, 2);

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_transaction_items');
    }
};
