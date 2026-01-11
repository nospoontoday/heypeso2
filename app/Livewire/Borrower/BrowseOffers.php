<?php

namespace App\Livewire\Borrower;

use App\Models\LoanOffer;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class BrowseOffers extends Component
{
    public bool $bypassValidations = false;

    public function getBorrowerTierProperty()
    {
        $reputation = auth()->user()->reputationScore;
        return $reputation ? $reputation->tier : 'default';
    }

    public function getOffersProperty()
    {
        $query = LoanOffer::with('lender')
            ->active()
            ->where('borrower_tier', $this->borrowerTier);

        // Filter by amount limits for tier
        $maxLimit = config('borrower.loan_limits')[$this->borrowerTier];
        $query->where('max_amount', '<=', $maxLimit);

        // Filter by interest rate range
        $rateRange = config('borrower.recommended_interest_rates')[$this->borrowerTier];
        $query->whereBetween('interest_rate', [$rateRange['min'], $rateRange['max']]);

        // Premium offers only for premium borrowers
        if ($this->borrowerTier !== 'premium') {
            $query->where('is_premium_offer', false);
        }

        // Exclude full offers
        $query->whereRaw('available_slots > 0'); // Placeholder, assuming no slots_taken field yet

        return $query->get();
    }



    public function applyForOffer($offerId)
    {
        // Placeholder for apply logic
        session()->flash('message', 'Application submitted successfully!');
    }

    public function render()
    {
        return view('livewire.borrower.browse-offers');
    }
}
