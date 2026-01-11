<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReputationScore extends Model
{
    protected $fillable = [
        'user_id',
        'score',
        'tier',
        'loans_completed',
        'loans_defaulted',
    ];

    protected $casts = [
        'score' => 'integer',
        'loans_completed' => 'integer',
        'loans_defaulted' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTierBadge()
    {
        return config('borrower.tier_badges')[$this->tier] ?? config('borrower.tier_badges')['default'];
    }

    public function getMaxLoanAmount()
    {
        return config('borrower.loan_limits')[$this->tier] ?? config('borrower.loan_limits')['default'];
    }

    public function getRecommendedInterestRange()
    {
        return config('borrower.recommended_interest_rates')[$this->tier] ?? config('borrower.recommended_interest_rates')['default'];
    }

    public function getMaxDuration()
    {
        return config('borrower.max_durations')[$this->tier] ?? config('borrower.max_durations')['default'];
    }
}
