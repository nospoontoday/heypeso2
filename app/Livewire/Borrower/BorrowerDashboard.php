<?php

namespace App\Livewire\Borrower;

use Livewire\Component;

class BorrowerDashboard extends Component
{
    public function getReputationScoreProperty()
    {
        return auth()->user()->reputationScore ?? null;
    }

    public function getTierBadgeProperty()
    {
        return $this->reputationScore ? $this->reputationScore->getTierBadge() : config('borrower.tier_badges')['default'];
    }

    public function getStatsProperty()
    {
        // Placeholder stats
        return [
            'pending_applications' => 0,
            'active_loans' => 0,
            'total_borrowed' => 0,
            'repaid_loans' => 0,
        ];
    }

    public function render()
    {
        return view('livewire.borrower.borrower-dashboard');
    }
}
