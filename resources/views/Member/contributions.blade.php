<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Contributions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Add Contribution Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-8">
                <h3 class="font-semibold text-lg mb-4">Record New Contribution</h3>
                <form method="POST" action="{{ route('member.contributions.store') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @csrf
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700">Amount (Ksh)</label>
                        <input type="number" step="0.01" name="amount" id="amount" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="contribution_date" class="block text-sm font-medium text-gray-700">Date</label>
                        <input type="date" name="contribution_date" id="contribution_date" value="{{ date('Y-m-d') }}" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="reference" class="block text-sm font-medium text-gray-700">Reference (Optional)</label>
                        <input type="text" name="reference" id="reference" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="e.g., M-Pesa code">
                    </div>
                    <div class="md:col-span-3">
                        <label for="notes" class="block text-sm font-medium text-gray-700">Notes (Optional)</label>
                        <textarea name="notes" id="notes" rows="2" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                    <div class="md:col-span-3">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">💾 Save Contribution</button>
                    </div>
                </form>
            </div>

            <!-- Contributions Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Contribution History</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Source</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($contributions ?? [] as $contribution)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $contribution->contribution_date->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Ksh {{ number_format($contribution->amount, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $contribution->source === 'mpesa' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($contribution->source) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $contribution->reference ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $contribution->notes ?? '—' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No contributions recorded yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>