<div>
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        @if(auth()->user()->isLender())
            <!-- Lender Dashboard -->
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">{{ __('Lender Dashboard') }}</h1>
                <flux:button wire:click="openCreateOfferModal" variant="primary">
                    {{ __('Create Loan Offer') }}
                </flux:button>
            </div>
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
                    <h3 class="text-lg font-semibold">{{ __('Active Offers') }}</h3>
                    @if($this->activeOffers->count() > 0)
                        <div class="mt-2 space-y-2 max-h-32 overflow-y-auto">
                            @foreach($this->activeOffers as $offer)
                                <div class="bg-gray-50 dark:bg-gray-800 p-2 rounded text-xs">
                                    <p class="font-medium">{{ config('borrower.tier_badges')[$offer->borrower_tier]['name'] }} - ₱{{ number_format($offer->min_amount) }} - ₱{{ number_format($offer->max_amount) }}</p>
                                    <p class="text-gray-600 dark:text-gray-400">{{ $offer->interest_rate }}% interest, {{ $offer->duration_months }} months</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600 dark:text-gray-400 mt-2">No active offers yet</p>
                    @endif
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
                    <h3 class="text-lg font-semibold">{{ __('Borrower Applications') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">Review applications</p>
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
                    <h3 class="text-lg font-semibold">{{ __('Analytics') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">View performance metrics</p>
                </div>
            </div>
        @else
            <!-- Borrower Dashboard -->
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">{{ __('Borrower Dashboard') }}</h1>
            </div>
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
                    <h3 class="text-lg font-semibold">{{ __('Available Offers') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">Browse loan offers</p>
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
                    <h3 class="text-lg font-semibold">{{ __('My Loans') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">Track your loans</p>
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
                    <h3 class="text-lg font-semibold">{{ __('Payment History') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">View payments</p>
                </div>
            </div>
        @endif
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-800">
            <div class="flex items-center justify-center h-full">
                <p class="text-gray-500 dark:text-gray-400 text-lg">{{ __('Content coming soon') }}</p>
            </div>
        </div>
    </div>

    <livewire:lender.create-loan-offer />
</div>
