<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('invoices.store') }}" method="POST" id="invoice-form">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="customer_id" class="block text-sm font-medium text-gray-700">Customer</label>
                                <select name="customer_id" id="customer_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="invoice_date" class="block text-sm font-medium text-gray-700">Invoice Date</label>
                                <input type="date" name="invoice_date" id="invoice_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ date('Y-m-d') }}" required>
                                @error('invoice_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                                <input type="date" name="due_date" id="due_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ date('Y-m-d', strtotime('+30 days')) }}" required>
                                @error('due_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="invoice_number" class="block text-sm font-medium text-gray-700">Invoice Number</label>
                                <input type="text" name="invoice_number" id="invoice_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ $invoiceNumber }}" readonly>
                                @error('invoice_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-8">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 250px;">Service</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 200px;">HSN</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 200px;">Rate</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 200px;">Quantity</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 150px;">CGST</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 150px;">SGST</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 150px;">IGST</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 200px;">Discount</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 220px;">Scheme Amount</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 220px;">Basic Amount</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 220px;">GST Amount</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 220px;">Total</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 150px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200" id="invoice-items">
                                        <!-- Dynamic rows will be added here -->
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="mt-4">
                                <button type="button" id="add-row" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                    Add Row
                                </button>
                            </div>

                            <div class="mt-8 grid grid-cols-2 gap-6">
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                                    <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                </div>
                                <div class="space-y-4">
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-700">Subtotal:</span>
                                        <span id="subtotal" class="text-sm text-gray-900">0.00</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-700">Total GST:</span>
                                        <span id="total-gst" class="text-sm text-gray-900">0.00</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-700">Total Discount:</span>
                                        <span id="total-discount" class="text-sm text-gray-900">0.00</span>
                                    </div>
                                    <div class="flex justify-between border-t pt-2">
                                        <span class="text-base font-medium text-gray-900">Grand Total:</span>
                                        <span id="grand-total" class="text-base font-medium text-gray-900">0.00</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                    Create Invoice
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add first row automatically
            addRow();

            // Add row button click handler
            document.getElementById('add-row').addEventListener('click', addRow);

            // Form submission handler
            document.getElementById('invoice-form').addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Validate form
                if (!validateForm()) {
                    return;
                }

                // Submit form
                this.submit();
            });

            function validateForm() {
                const customerId = document.getElementById('customer_id').value;
                const invoiceDate = document.getElementById('invoice_date').value;
                const dueDate = document.getElementById('due_date').value;
                const rows = document.querySelectorAll('#invoice-items tr');

                if (!customerId) {
                    alert('Please select a customer');
                    return false;
                }

                if (!invoiceDate) {
                    alert('Please select an invoice date');
                    return false;
                }

                if (!dueDate) {
                    alert('Please select a due date');
                    return false;
                }

                if (rows.length === 0) {
                    alert('Please add at least one item to the invoice');
                    return false;
                }

                // Validate each row
                for (let row of rows) {
                    const service = row.querySelector('.service-select').value;
                    const quantity = row.querySelector('input[name$="[quantity]"]').value;

                    if (!service) {
                        alert('Please select a service for all rows');
                        return false;
                    }

                    if (!quantity || quantity <= 0) {
                        alert('Please enter a valid quantity for all rows');
                        return false;
                    }
                }

                return true;
            }

            function addRow() {
                const tbody = document.getElementById('invoice-items');
                const rowCount = tbody.children.length;
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <select name="items[${rowCount}][service_id]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 service-select" required>
                            <option value="">Select Service</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" 
                                    data-hsn="{{ $service->hsn }}"
                                    data-rate="{{ $service->rate }}"
                                    data-cgst="{{ $service->cgst_rate }}"
                                    data-sgst="{{ $service->sgst_rate }}"
                                    data-igst="{{ $service->igst_rate }}">
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="text" name="items[${rowCount}][hsn]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" readonly>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="number" name="items[${rowCount}][rate]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" step="0.01" readonly>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="number" name="items[${rowCount}][quantity]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" step="1" required min="1">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="number" name="items[${rowCount}][cgst]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" step="0.01" readonly>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="number" name="items[${rowCount}][sgst]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" step="0.01" readonly>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="number" name="items[${rowCount}][igst]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" step="0.01" readonly>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="number" name="items[${rowCount}][discount]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" step="0.01" min="0">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="number" name="items[${rowCount}][scheme_amount]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" step="0.01" min="0">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="basic-amount">0.00</span>
                        <input type="hidden" name="items[${rowCount}][basic_amount]" class="basic-amount-input" value="0">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="gst-amount">0.00</span>
                        <input type="hidden" name="items[${rowCount}][gst_amount]" class="gst-amount-input" value="0">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="total-amount">0.00</span>
                        <input type="hidden" name="items[${rowCount}][total_amount]" class="total-amount-input" value="0">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button type="button" class="text-red-600 hover:text-red-900 delete-row">Delete</button>
                    </td>
                `;
                tbody.appendChild(newRow);
                attachRowEventListeners(newRow);
            }

            function attachRowEventListeners(row) {
                const serviceSelect = row.querySelector('.service-select');
                const quantityInput = row.querySelector('input[name$="[quantity]"]');
                const discountInput = row.querySelector('input[name$="[discount]"]');
                const schemeAmountInput = row.querySelector('input[name$="[scheme_amount]"]');
                const deleteButton = row.querySelector('.delete-row');

                serviceSelect.addEventListener('change', function() {
                    const option = this.options[this.selectedIndex];
                    const hsn = option.dataset.hsn;
                    const rate = option.dataset.rate;
                    const cgst = option.dataset.cgst;
                    const sgst = option.dataset.sgst;
                    const igst = option.dataset.igst;

                    row.querySelector('input[name$="[hsn]"]').value = hsn;
                    row.querySelector('input[name$="[rate]"]').value = rate;
                    row.querySelector('input[name$="[cgst]"]').value = cgst;
                    row.querySelector('input[name$="[sgst]"]').value = sgst;
                    row.querySelector('input[name$="[igst]"]').value = igst;

                    calculateRowAmounts(row);
                });

                quantityInput.addEventListener('input', () => calculateRowAmounts(row));
                discountInput.addEventListener('input', () => calculateRowAmounts(row));
                schemeAmountInput.addEventListener('input', () => calculateRowAmounts(row));

                deleteButton.addEventListener('click', function() {
                    if (document.querySelectorAll('#invoice-items tr').length > 1) {
                        row.remove();
                        calculateTotals();
                    } else {
                        alert('Cannot delete the last row');
                    }
                });
            }

            function calculateRowAmounts(row) {
                const rate = parseFloat(row.querySelector('input[name$="[rate]"]').value) || 0;
                const quantity = parseFloat(row.querySelector('input[name$="[quantity]"]').value) || 0;
                const discount = parseFloat(row.querySelector('input[name$="[discount]"]').value) || 0;
                const schemeAmount = parseFloat(row.querySelector('input[name$="[scheme_amount]"]').value) || 0;
                const cgst = parseFloat(row.querySelector('input[name$="[cgst]"]').value) || 0;
                const sgst = parseFloat(row.querySelector('input[name$="[sgst]"]').value) || 0;
                const igst = parseFloat(row.querySelector('input[name$="[igst]"]').value) || 0;

                const basicAmount = (rate * quantity) - discount - schemeAmount;
                const gstAmount = basicAmount * ((cgst + sgst + igst) / 100);
                const total = basicAmount + gstAmount;

                row.querySelector('.basic-amount').textContent = basicAmount.toFixed(2);
                row.querySelector('.gst-amount').textContent = gstAmount.toFixed(2);
                row.querySelector('.total-amount').textContent = total.toFixed(2);

                // Update hidden input values
                row.querySelector('.basic-amount-input').value = basicAmount.toFixed(2);
                row.querySelector('.gst-amount-input').value = gstAmount.toFixed(2);
                row.querySelector('.total-amount-input').value = total.toFixed(2);

                calculateTotals();
            }

            function calculateTotals() {
                let subtotal = 0;
                let totalGst = 0;
                let totalDiscount = 0;

                document.querySelectorAll('#invoice-items tr').forEach(row => {
                    subtotal += parseFloat(row.querySelector('.basic-amount').textContent) || 0;
                    totalGst += parseFloat(row.querySelector('.gst-amount').textContent) || 0;
                    totalDiscount += parseFloat(row.querySelector('input[name$="[discount]"]').value) || 0;
                });

                const grandTotal = subtotal + totalGst;

                document.getElementById('subtotal').textContent = subtotal.toFixed(2);
                document.getElementById('total-gst').textContent = totalGst.toFixed(2);
                document.getElementById('total-discount').textContent = totalDiscount.toFixed(2);
                document.getElementById('grand-total').textContent = grandTotal.toFixed(2);
            }
        });
    </script>
    @endpush
</x-app-layout> 