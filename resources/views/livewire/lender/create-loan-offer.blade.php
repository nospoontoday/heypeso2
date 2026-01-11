<div>
    <flux:modal name="create-loan-offer" class="md:w-[30rem]" wire:model="showModal" @close="closeModal">
        <form wire:submit="submit" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Create Loan Offer') }}</flux:heading>
                <flux:subheading>{{ __('Set up a new loan offer for borrowers.') }}</flux:subheading>
            </div>

            <div class="space-y-4">
                <!-- Borrower Tier -->
                <flux:select wire:model.live="borrower_tier" :label="__('Target Borrower Tier')" required>
                    @foreach(config('borrower.tier_badges') as $tier => $badge)
                        <option value="{{ $tier }}">
                            {{ $badge['emoji'] }} {{ $badge['name'] }} - {{ $badge['description'] }}
                        </option>
                    @endforeach
                </flux:select>

                <!-- Min Amount -->
                <flux:input
                    wire:model="min_amount"
                    :label="__('Min Loan Amount (₱)')"
                    type="number"
                    min="1000"
                    required
                />

                <!-- Max Amount -->
                <div>
                    <flux:input
                        wire:model="max_amount"
                        :label="__('Max Loan Amount (₱)')"
                        type="number"
                        required
                    />
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Max allowed:') }} ₱{{ number_format(config('borrower.loan_limits')[$borrower_tier]) }}
                    </p>
                </div>

                <!-- Interest Rate -->
                <div>
                    <flux:input
                        wire:model="interest_rate"
                        :label="__('Interest Rate (%)')"
                        type="number"
                        step="0.01"
                        required
                    />
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Range:') }} {{ config('borrower.recommended_interest_rates')[$borrower_tier]['min'] }}% - {{ config('borrower.recommended_interest_rates')[$borrower_tier]['max'] }}%
                    </p>
                </div>

                <!-- Monthly Fee -->
                <flux:input
                    wire:model="monthly_fee"
                    :label="__('Monthly Fee (₱) - Optional')"
                    type="number"
                    step="0.01"
                    placeholder="Optional"
                />

                <!-- Duration -->
                <flux:select wire:model="duration_months" :label="__('Duration (Months)')" required>
                    @for($i = 1; $i <= config('borrower.max_durations')[$borrower_tier]; $i++)
                        <option value="{{ $i }}">{{ $i }} month{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                </flux:select>

                <!-- Available Slots -->
                <flux:input
                    wire:model="available_slots"
                    :label="__('Available Slots')"
                    type="number"
                    min="1"
                    max="50"
                    required
                />

                <!-- Cooldown Days -->
                <flux:input
                    wire:model="cooldown_days"
                    :label="__('Reapplication Cooldown (Days)')"
                    type="number"
                    required
                />

                <!-- Status -->
                <flux:select wire:model="status" :label="__('Status')" required>
                    <option value="active">{{ __('Active') }}</option>
                    <option value="inactive">{{ __('Inactive') }}</option>
                </flux:select>

                <!-- Terms -->
                <flux:textarea
                    wire:model="terms"
                    :label="__('Terms & Conditions - Optional')"
                    rows="3"
                    placeholder="Optional terms and conditions..."
                />
            </div>

            <div class="flex space-x-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="primary">{{ __('Create Offer') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
