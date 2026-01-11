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
        Schema::table('loan_offers', function (Blueprint $table) {
            $table->boolean('is_premium_offer')->default(false);
            $table->enum('required_tier', ['default', 'building', 'reliable', 'premium'])->nullable();
            $table->integer('min_reputation_score')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_offers', function (Blueprint $table) {
            $table->dropColumn(['is_premium_offer', 'required_tier', 'min_reputation_score']);
        });
    }
};
