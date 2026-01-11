<?php

namespace App\Models;

use App\Traits\ManagesTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoanOffer extends Model
{
    use ManagesTime;

    protected $fillable = [
        'lender_id',
        'borrower_tier',
        'min_amount',
        'max_amount',
        'interest_rate',
        'monthly_fee',
        'duration_months',
        'available_slots',
        'cooldown_days',
        'status',
        'terms',
        'is_premium_offer',
        'required_tier',
        'min_reputation_score',
    ];

    protected $casts = [
        'min_amount' => 'decimal:2',
        'max_amount' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'monthly_fee' => 'decimal:2',
        'status' => 'string',
        'is_premium_offer' => 'boolean',
        'min_reputation_score' => 'integer',
    ];

    public function lender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'lender_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByTier($query, $tier)
    {
        return $query->where('borrower_tier', $tier);
    }

    public function isWithinLimits(): bool
    {
        $limits = config('borrower.loan_limits')[$this->borrower_tier] ?? 0;
        return $this->max_amount <= $limits;
    }

    public function isFull(): bool
    {
        // Placeholder: assume slots_taken field or count applications
        return false; // Implement based on actual logic
    }
}
