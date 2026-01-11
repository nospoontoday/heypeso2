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
        Schema::create('loan_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lender_id')->constrained('users')->onDelete('cascade');
            $table->enum('borrower_tier', ['default', 'building', 'reliable', 'premium']);
            $table->decimal('min_amount', 10, 2);
            $table->decimal('max_amount', 10, 2);
            $table->decimal('interest_rate', 5, 2);
            $table->decimal('monthly_fee', 8, 2)->nullable();
            $table->unsignedTinyInteger('duration_months');
            $table->unsignedSmallInteger('available_slots');
            $table->unsignedSmallInteger('cooldown_days');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->text('terms')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_offers');
    }
};
