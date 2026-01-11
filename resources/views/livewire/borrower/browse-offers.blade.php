<div>
    @if($this->offers->count() > 0)
        <div class="mt-2 space-y-2 max-h-32 overflow-y-auto">
            @foreach($this->offers as $offer)
                <div class="bg-gray-50 dark:bg-gray-800 p-2 rounded text-xs">
                    <p class="font-medium">{{ $offer->lender->name }} - ₱{{ number_format($offer->min_amount) }} - ₱{{ number_format($offer->max_amount) }}</p>
                    <p class="text-gray-600 dark:text-gray-400">{{ $offer->interest_rate }}% interest, {{ $offer->duration_months }} months</p>
                    <p class="text-gray-500 dark:text-gray-500">{{ $offer->available_slots }} slots available</p>
                    <flux:button variant="outline" size="sm" wire:click="applyForOffer({{ $offer->id }})">
                        {{ __('Apply Now') }}
                    </flux:button>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-4">
            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('No offers available for your tier.') }}</p>
        </div>
    @endif
</div>
