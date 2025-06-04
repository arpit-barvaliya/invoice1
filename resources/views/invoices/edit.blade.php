<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('invoices.update', $invoice) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="customer_id" value="Customer" />
                                <select name="customer_id" id="customer_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Select a customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ old('customer_id', $invoice->customer_id) == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('customer_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="invoice_date" value="Invoice Date" />
                                <x-text-input id="invoice_date" name="invoice_date" type="date" class="mt-1 block w-full" :value="old('invoice_date', $invoice->invoice_date->format('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('invoice_date')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="due_date" value="Due Date" />
                                <x-text-input id="due_date" name="due_date" type="date" class="mt-1 block w-full" :value="old('due_date', $invoice->due_date->format('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="tax_rate" value="Tax Rate (%)" />
                                <x-text-input id="tax_rate" name="tax_rate" type="number" class="mt-1 block w-full" :value="old('tax_rate', $invoice->tax_rate)" min="0" max="100" step="0.01" required />
                                <x-input-error :messages="$errors->get('tax_rate')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="status" value="Status" />
                                <select name="status" id="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="draft" {{ old('status', $invoice->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="sent" {{ old('status', $invoice->status) == 'sent' ? 'selected' : '' }}>Sent</option>
                                    <option value="paid" {{ old('status', $invoice->status) == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="overdue" {{ old('status', $invoice->status) == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="notes" value="Notes" />
                            <textarea id="notes" name="notes" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('notes', $invoice->notes) }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <div class="flex justify-end">
                            <x-primary-button>
                                {{ __('Update Invoice') }}
                            </x-primary-button>
                        </div>
                    </form>

                    @include('invoices._services_form')
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('invoiceForm');
            const subtotalInput = document.getElementById('subtotal');
            const taxRateInput = document.getElementById('tax_rate');

            function calculateTotals() {
                const subtotal = parseFloat(subtotalInput.value) || 0;
                const taxRate = parseFloat(taxRateInput.value) || 0;
                const taxAmount = (subtotal * taxRate) / 100;
                const total = subtotal + taxAmount;

                // You can display these values in the form if needed
                console.log('Tax Amount:', taxAmount);
                console.log('Total:', total);
            }

            subtotalInput.addEventListener('input', calculateTotals);
            taxRateInput.addEventListener('input', calculateTotals);
        });
    </script>
    @endpush
</x-app-layout> 