<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('SMS Parser & Unmapped Queue') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Quick Parse Button -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-8">
                <button onclick="openSmsModal()" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg transition shadow-md">
                    📱 Parse New SMS
                </button>
                <p class="text-sm text-gray-500 mt-2">Paste an M-Pesa confirmation message to auto-record contributions.</p>
            </div>

            <!-- Unmapped Queue -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Unmapped Transactions</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sender</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($transactions ?? [] as $tx)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $tx->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Ksh {{ number_format($tx->amount, 2) }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $tx->sender ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $tx->transaction_code ?? '—' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $tx->status === 'mapped' ? 'bg-green-100 text-green-800' : ($tx->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ ucfirst($tx->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if($tx->status === 'unmapped')
                                            <button onclick="matchTransaction({{ $tx->id }})" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm transition">Match</button>
                                            <button onclick="rejectTransaction({{ $tx->id }})" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition">Reject</button>
                                        @else
                                            <span class="text-gray-400">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No M-Pesa transactions found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('partials.sms-modal')

    @push('scripts')
    <script>
        function matchTransaction(id) {
            // Placeholder: implement AJAX to match transaction with a member
            const memberId = prompt('Enter the member ID to match this transaction:');
            if (memberId) {
                fetch(`/treasurer/sms-parser/${id}/match`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ user_id: memberId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Transaction matched successfully!');
                        window.location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => alert('Network error.'));
            }
        }

        function rejectTransaction(id) {
            if (confirm('Reject this transaction?')) {
                fetch(`/treasurer/sms-parser/${id}/reject`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Transaction rejected.');
                        window.location.reload();
                    }
                });
            }
        }
    </script>
    @endpush
</x-app-layout>