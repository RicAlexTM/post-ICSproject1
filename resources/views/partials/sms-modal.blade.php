<div id="smsModal" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm hidden items-center justify-center z-50" x-data="smsParserModal()" x-init="init()">
    <div class="bg-white rounded-xl max-w-2xl w-full mx-4 shadow-2xl transform transition-all">
        <div class="flex items-center justify-between p-6 border-b">
            <h3 class="text-xl font-bold">Parse M-Pesa SMS</h3>
            <button @click="closeModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>
        <div class="p-6">
            <div x-show="!parsed">
                <p class="text-sm text-gray-600 mb-3">Paste the M-Pesa confirmation SMS below:</p>
                <textarea x-model="smsText" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 h-32" placeholder="Paste your M-Pesa SMS here..."></textarea>
                <button @click="parseSms()" class="mt-3 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition w-full" :disabled="loading">
                    <span x-show="!loading">🔍 Parse SMS</span>
                    <span x-show="loading" class="flex items-center justify-center gap-2">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Processing...
                    </span>
                </button>
            </div>
            <div x-show="parsed" x-cloak>
                <h4 class="font-semibold text-lg mb-3">Extracted Details</h4>
                <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                    <div class="flex justify-between"><span class="text-gray-600">Amount:</span> <span class="font-bold" x-text="parsedData.amount"></span></div>
                    <div class="flex justify-between"><span class="text-gray-600">Sender:</span> <span x-text="parsedData.sender"></span></div>
                    <div class="flex justify-between"><span class="text-gray-600">Transaction Code:</span> <span x-text="parsedData.transaction_code"></span></div>
                    <div class="flex justify-between"><span class="text-gray-600">Date:</span> <span x-text="parsedData.date"></span></div>
                </div>
                <div class="mt-4 flex gap-3">
                    <button @click="confirmRecord()" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition flex-1">✅ Confirm & Record</button>
                    <button @click="parsed = false; parsedData = {}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-lg transition">↩️ Back</button>
                </div>
                <p class="text-xs text-gray-500 mt-2">If the sender is not auto-matched, the transaction will be sent to the unmapped queue.</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function smsParserModal() {
        return {
            smsText: '',
            loading: false,
            parsed: false,
            parsedData: {},
            init() {
                // Expose open function globally
                window.openSmsModal = () => {
                    document.getElementById('smsModal').classList.remove('hidden');
                    document.getElementById('smsModal').classList.add('flex');
                };
                // Close on outside click
                document.getElementById('smsModal').addEventListener('click', function(e) {
                    if (e.target === this) {
                        this.classList.add('hidden');
                        this.classList.remove('flex');
                    }
                });
            },
            closeModal() {
                document.getElementById('smsModal').classList.add('hidden');
                document.getElementById('smsModal').classList.remove('flex');
                this.smsText = '';
                this.parsed = false;
                this.parsedData = {};
            },
            parseSms() {
                if (!this.smsText.trim()) {
                    alert('Please paste an SMS message.');
                    return;
                }
                this.loading = true;
                fetch('{{ route("treasurer.sms-parser.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ message: this.smsText })
                })
                .then(response => response.json())
                .then(data => {
                    this.loading = false;
                    if (data.success) {
                        this.parsedData = data.data;
                        this.parsed = true;
                    } else {
                        alert('Error parsing SMS: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    this.loading = false;
                    alert('Network error. Please try again.');
                    console.error(error);
                });
            },
            confirmRecord() {
                // You can implement auto-confirm if needed; or redirect to unmapped queue
                alert('Transaction recorded. You can review it in the SMS Parser page.');
                this.closeModal();
                window.location.reload();
            }
        }
    }
</script>
@endpush