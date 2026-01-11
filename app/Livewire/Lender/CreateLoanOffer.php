<?php

namespace App\Livewire\Lender;

use App\Models\LoanOffer;
use Livewire\Component;

class CreateLoanOffer extends Component
{
    public bool $showModal = false;
    public string $borrower_tier = 'default';
    public int $min_amount = 1000;
    public int $max_amount;
    public float $interest_rate;
    public ?float $monthly_fee = null;
    public int $duration_months = 1;
    public int $available_slots = 1;
    public int $cooldown_days = 30;
    public string $status = 'active';
    public ?string $terms = null;

    protected $listeners = ['open-create-loan-offer-modal' => 'openModal'];

    public function mount()
    {
        $this->setDefaultsForTier();
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function updatedBorrowerTier()
    {
        $this->setDefaultsForTier();
    }

    private function setDefaultsForTier()
    {
        $rates = config('borrower.recommended_interest_rates')[$this->borrower_tier];
        $this->interest_rate = $rates['min'];
        $this->max_amount = config('borrower.loan_limits')[$this->borrower_tier];
        $this->duration_months = min($this->duration_months, config('borrower.max_durations')[$this->borrower_tier]);
        $this->cooldown_days = config('lender.default_reapplication_cooldown_days');
    }

    public function submit()
    {
        $this->validate([
            'borrower_tier' => 'required|in:default,building,reliable,premium',
            'min_amount' => 'required|integer|min:1000',
            'max_amount' => 'required|integer|min:' . $this->min_amount . '|max:' . config('borrower.loan_limits')[$this->borrower_tier],
            'interest_rate' => 'required|numeric|min:' . config('borrower.recommended_interest_rates')[$this->borrower_tier]['min'] . '|max:' . config('borrower.recommended_interest_rates')[$this->borrower_tier]['max'],
            'monthly_fee' => 'nullable|numeric|max:50',
            'duration_months' => 'required|integer|min:1|max:' . config('borrower.max_durations')[$this->borrower_tier],
            'available_slots' => 'required|integer|min:1|max:50',
            'cooldown_days' => 'required|integer|min:' . config('lender.minimum_reapplication_cooldown_days') . '|max:' . config('lender.maximum_reapplication_cooldown_days'),
            'status' => 'required|in:active,inactive',
            'terms' => 'nullable|string|max:1000',
        ]);

        // Check if amounts match tier limits exactly or show error
        if ($this->max_amount > config('borrower.loan_limits')[$this->borrower_tier]) {
            $this->addError('max_amount', 'Max amount exceeds tier limit of ₱' . number_format(config('borrower.loan_limits')[$this->borrower_tier]));
            return;
        }

        LoanOffer::create([
            'lender_id' => auth()->id(),
            'borrower_tier' => $this->borrower_tier,
            'min_amount' => $this->min_amount,
            'max_amount' => $this->max_amount,
            'interest_rate' => $this->interest_rate,
            'monthly_fee' => $this->monthly_fee,
            'duration_months' => $this->duration_months,
            'available_slots' => $this->available_slots,
            'cooldown_days' => $this->cooldown_days,
            'status' => $this->status,
            'terms' => $this->terms,
        ]);

        $this->dispatch('offer-created');
        session()->flash('message', 'Loan offer created successfully!');
        $this->closeModal();
    }

    private function resetForm()
    {
        $this->borrower_tier = 'default';
        $this->min_amount = 1000;
        $this->monthly_fee = null;
        $this->duration_months = 1;
        $this->available_slots = 1;
        $this->cooldown_days = 30;
        $this->status = 'active';
        $this->terms = null;
        $this->setDefaultsForTier();
    }

    public function render()
    {
        return view('livewire.lender.create-loan-offer');
    }
}
