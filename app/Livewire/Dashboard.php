<?php

namespace App\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    protected $listeners = ['offer-created' => '$refresh'];

    public function openCreateOfferModal()
    {
        $this->dispatch('open-create-loan-offer-modal')->to('lender.create-loan-offer');
    }

    public function getActiveOffersProperty()
    {
        return auth()->user()->loanOffers()->active()->get();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
