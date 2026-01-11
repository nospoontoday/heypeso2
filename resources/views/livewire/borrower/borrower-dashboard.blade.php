<div>
    <!-- Tab content will be loaded here -->
    @if($activeTab === 'browse')
        <livewire:borrower.browse-offers />
    @elseif($activeTab === 'applications')
        <p>My Applications</p>
    @elseif($activeTab === 'loans')
        <p>My Loans</p>
    @elseif($activeTab === 'referrals')
        <p>Referrals</p>
    @endif
</div>
