<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Treasurer Dashboard') }}
            </h2>
            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">
                {{ Auth::user()->chama->name ?? 'Chama' }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-sm text-gray-500">Total Savings</div>
                    <div class="text-2xl font-bold text-blue-600">Ksh {{ number_format($totalSavings ?? 0, 2) }}</div>
                    <div class="text-xs text-gray-400 mt-1">All members combined</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-sm text-gray-500">Active Loans</div>
                    <div class="text-2xl font-bold text-green-600">Ksh {{ number_format($activeLoans ?? 0, 2) }}</div>
                    <div class="text-xs text-gray-400 mt-1">{{ $activeLoansCount ?? 0 }} active loans</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-sm text-gray-500">Pending Approvals</div>
                    <div class="text-2xl font-bold text-yellow-600">{{ $pendingApplications ?? 0 }}</div>
                    <div class="text-xs text-gray-400 mt-1">Awaiting your review</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-red-500">
                    <div class="text-sm text-gray-500">Outstanding Fines</div>
                    <div class="text-2xl font-bold text-red-600">Ksh {{ number_format($totalFines ?? 0, 2) }}</div>
                    <div class="text-xs text-gray-400 mt-1">{{ $unpaidFinesCount ?? 0 }} unpaid fines</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-8">
                <h3 class="font-semibold text-lg mb-4">Quick Actions</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('member.contributions') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg transition shadow-md hover:shadow-lg">
                        ➕ Add Contribution
                    </a>
                    <button onclick="openSmsModal()" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-lg transition shadow-md hover:shadow-lg">
                        📱 Parse SMS
                    </button>
                    <a href="{{ route('member.loans') }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2.5 px-6 rounded-lg transition shadow-md hover:shadow-lg">
                        📋 Loan Applications
                        @if($pendingApplications ?? 0 > 0)
                            <span class="ml-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ $pendingApplications }}</span>
                        @endif
                    </a>
                    <a href="{{ route('reports.treasurer') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2.5 px-6 rounded-lg transition shadow-md hover:shadow-lg">
                        📄 Generate Report
                    </a>
                    <a href="{{ route('treasurer.penalties') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-6 rounded-lg transition shadow-md hover:shadow-lg">
                        ⚠️ Penalty Management
                    </a>
                </div>
            </div>

            <!-- Pending Loan Applications Quick View -->
            @if($pendingApplications > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-8">
                    <h3 class="font-semibold text-lg mb-4">Pending Loan Applications</h3>
                    <div class="space-y-3">
                        @foreach($pendingLoanList ?? [] as $loan)
                            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                                <div>
                                    <p class="font-medium">{{ $loan->user->name }}</p>
                                    <p class="text-sm text-gray-500">Amount: Ksh {{ number_format($loan->amount, 2) }} | Term: {{ $loan->term_months }} months</p>
                                </div>
                                <div class="flex gap-2">
                                    <form action="{{ route('member.loans.store') }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="loan_id" value="{{ $loan->id }}">
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-1.5 rounded-lg text-sm transition">Approve</button>
                                    </form>
                                    <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-1.5 rounded-lg text-sm transition">Reject</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a href="{{ route('member.loans') }}" class="text-blue-600 hover:underline text-sm mt-3 inline-block">View all pending applications →</a>
                </div>
            @endif

            <!-- Recent Transactions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-lg">Recent Transactions</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recentTransactions ?? [] as $transaction)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $transaction->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $transaction->user->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $transaction->type === 'credit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($transaction->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ $transaction->type === 'credit' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $transaction->type === 'credit' ? '+' : '-' }} Ksh {{ number_format($transaction->amount, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">No recent transactions.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Include SMS Modal Partial -->
    @include('partials.sms-modal')
</x-app-layout>