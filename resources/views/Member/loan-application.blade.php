<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Loan Application') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Loan Application Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-8">
                <h3 class="font-semibold text-lg mb-4">Apply for a Loan</h3>
                <form method="POST" action="{{ route('member.loans.store') }}" x-data="loanCalculator()" x-init="init()">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700">Amount (Ksh)</label>
                            <input type="number" step="0.01" name="amount" id="amount" x-model="amount" x-on:input="calculate()" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="term_months" class="block text-sm font-medium text-gray-700">Repayment Period (months)</label>
                            <select name="term_months" id="term_months" x-model="term" x-on:change="calculate()" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="1">1 month</option>
                                <option value="3">3 months</option>
                                <option value="6">6 months</option>
                                <option value="12" selected>12 months</option>
                                <option value="18">18 months</option>
                                <option value="24">24 months</option>
                                <option value="36">36 months</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="reason" class="block text-sm font-medium text-gray-700">Reason for loan</label>
                        <textarea name="reason" id="reason" rows="2" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Briefly describe why you need this loan..."></textarea>
                    </div>

                    <!-- Real-time Calculator -->
                    <div class="mt-6 bg-gray-50 rounded-lg p-4 border border-gray-200" x-show="amount > 0 && term > 0">
                        <h4 class="font-semibold text-md mb-2">Loan Summary</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <span class="text-sm text-gray-600">Monthly Repayment</span>
                                <p class="text-lg font-bold text-blue-600" x-text="'Ksh ' + monthly_repayment.toFixed(2)"></p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600">Total Interest</span>
                                <p class="text-lg font-bold text-orange-600" x-text="'Ksh ' + total_interest.toFixed(2)"></p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600">Total Repayment</span>
                                <p class="text-lg font-bold text-green-600" x-text="'Ksh ' + total_repayment.toFixed(2)"></p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-8 rounded-lg transition shadow-md">
                            📤 Submit Application
                        </button>
                    </div>
                </form>
            </div>

            <!-- Existing Loans Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Your Loans</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Term</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($loans ?? [] as $loan)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loan->created_at->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Ksh {{ number_format($loan->amount, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full
                                            {{ $loan->status === 'approved' ? 'bg-green-100 text-green-800' :
                                               ($loan->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                               ($loan->status === 'repaid' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800')) }}">
                                            {{ ucfirst($loan->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $loan->term_months }} months</td>
                                    <td class="px-6 py-4 text-sm">
                                        @if($loan->status === 'approved')
                                            <form method="POST" action="{{ route('member.loans.repay', $loan) }}" class="inline">
                                                @csrf
                                                <input type="number" name="amount" placeholder="Amount" class="w-24 border-gray-300 rounded text-sm shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm transition">Repay</button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-xs">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No loans found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function loanCalculator() {
            return {
                amount: 0,
                term: 12,
                monthly_repayment: 0,
                total_interest: 0,
                total_repayment: 0,
                calculate() {
                    if (this.amount > 0 && this.term > 0) {
                        const principal = parseFloat(this.amount);
                        const months = parseInt(this.term);
                        const rate = 0.05; // 5% annual rate, adjust as needed
                        const monthlyRate = rate / 12;
                        const emi = principal * monthlyRate * Math.pow(1 + monthlyRate, months) / (Math.pow(1 + monthlyRate, months) - 1);
                        this.monthly_repayment = emi || 0;
                        this.total_repayment = emi * months;
                        this.total_interest = this.total_repayment - principal;
                    } else {
                        this.monthly_repayment = 0;
                        this.total_interest = 0;
                        this.total_repayment = 0;
                    }
                },
                init() {
                    this.calculate();
                }
            }
        }
    </script>
    @endpush
</x-app-layout>