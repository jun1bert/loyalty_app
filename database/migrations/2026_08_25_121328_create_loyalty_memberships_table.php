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
        Schema::create('loyalty_memberships', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('loyalty_plan_id')
                ->constrained()
                ->restrictOnDelete();

            $table->string('membership_code')->unique();
            $table->string('qr_token')->unique();

            $table->dateTime('activated_at')->nullable();
            $table->dateTime('expires_at')->nullable();

            $table->string('status')->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_memberships');
    }
};
