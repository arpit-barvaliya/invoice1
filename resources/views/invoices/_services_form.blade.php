<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Invoice Items</h3>

    <div class="w-full mb-4">
        <table class="w-full divide-y divide-gray-200" id="invoice-items-table">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">HSN</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rate</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CGST (%)</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SGST (%)</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IGST (%)</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Discount</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Scheme Amount</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Basic Amount</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">GST Amount</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @if(isset($invoice) && $invoice->services->count() > 0)
                    @foreach($invoice->services as $index => $service)
                        <tr data-id="{{ $service->id }}" class="invoice-item-row">
                            <td class="p-1">
                                <select name="items[{{ $index }}][service_id]" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm service-select" required>
                                    <option value="">Select a service</option>
                                    @foreach($services as $s)
                                        <option value="{{ $s->id }}" data-rate="{{ $s->rate }}" data-hsn="{{ $s->hsn ?? '' }}" {{ $service->service_id == $s->id ? 'selected' : '' }}>
                                            {{ $s->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-1">
                                <x-text-input type="text" name="items[{{ $index }}][hsn]" class="w-full hsn-input" value="{{ $service->service->hsn ?? '' }}" readonly />
                            </td>
                            <td class="p-1">
                                <x-text-input type="number" name="items[{{ $index }}][rate]" class="w-full rate-input" value="{{ old('items.' . $index . '.rate', number_format($service->rate, 2, '.', '')) }}" min="0" step="0.01" required />
                            </td>
                            <td class="p-1">
                                <x-text-input type="number" name="items[{{ $index }}][quantity]" class="w-full quantity-input" value="{{ old('items.' . $index . '.quantity', number_format($service->quantity, 0, '.', '')) }}" min="1" step="1" required />
                            </td>
                            <td class="p-1">
                                <x-text-input type="number" name="items[{{ $index }}][cgst]" class="w-full cgst-input" value="{{ old('items.' . $index . '.cgst', number_format($service->cgst_rate, 2, '.', '')) }}" min="0" step="0.01" required />
                            </td>
                            <td class="p-1">
                                <x-text-input type="number" name="items[{{ $index }}][sgst]" class="w-full sgst-input" value="{{ old('items.' . $index . '.sgst', number_format($service->sgst_rate, 2, '.', '')) }}" min="0" step="0.01" required />
                            </td>
                            <td class="p-1">
                                <x-text-input type="number" name="items[{{ $index }}][igst]" class="w-full igst-input" value="{{ old('items.' . $index . '.igst', number_format($service->igst_rate, 2, '.', '')) }}" min="0" step="0.01" required />
                            </td>
                            <td class="p-1">
                                <div class="relative">
                                    <x-text-input type="number" name="items[{{ $index }}][discount]" class="w-full discount-input pr-8" value="{{ old('items.' . $index . '.discount', number_format($service->discount, 2, '.', '')) }}" min="0" max="100" step="0.01" />
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <span class="text-gray-500">%</span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-1">
                                <x-text-input type="number" name="items[{{ $index }}][scheme_amount]" class="w-full scheme-amount-input" value="{{ old('items.' . $index . '.scheme_amount', number_format($service->scheme_amount, 2, '.', '')) }}" min="0" step="0.01" />
                            </td>
                            <td class="p-1">
                                <x-text-input type="number" name="items[{{ $index }}][basic_amount]" class="w-full basic-amount-input" value="{{ old('items.' . $index . '.basic_amount', number_format($service->basic_amount, 2, '.', '')) }}" min="0" step="0.01" readonly />
                            </td>
                            <td class="p-1">
                                <x-text-input type="number" name="items[{{ $index }}][gst_amount]" class="w-full gst-amount-input" value="{{ old('items.' . $index . '.gst_amount', number_format($service->gst_amount, 2, '.', '')) }}" min="0" step="0.01" readonly />
                            </td>
                            <td class="p-1">
                                <x-text-input type="number" name="items[{{ $index }}][total_amount]" class="w-full total-amount-input" value="{{ old('items.' . $index . '.total_amount', number_format($service->total_amount, 2, '.', '')) }}" min="0" step="0.01" readonly />
                            </td>
                            <td class="p-1 text-center">
                                <button type="button" class="text-red-600 hover:text-red-900 remove-item-btn p-2 rounded-md border border-gray-300 inline-flex items-center justify-center" title="Remove">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif
                <tr id="no-items-row" class="@if(isset($invoice) && $invoice->services->count() > 0) hidden @endif">
                    <td colspan="13" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">No services added yet.</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="flex justify-start mb-4">
        <x-secondary-button type="button" id="add-row-btn" class="bg-yellow-100 hover:bg-indigo-600 text-black">
            <i class="fas fa-plus mr-2"></i> Add Row
        </x-secondary-button>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8">
        <div class="col-span-2 md:col-span-2">
            <x-input-label for="notes" value="Notes" />
            <textarea id="notes" name="notes" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="2">{{ old('notes', $invoice->notes ?? '') }}</textarea>
            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
        </div>
        <div class="col-span-2">
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-700">Subtotal:</span>
                <x-text-input type="text" id="subtotal" name="subtotal" class="w-1/2 text-right bg-gray-50" value="{{ old('subtotal', number_format($invoice->subtotal, 2, '.', '')) }}" readonly />
            </div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-700">Total GST:</span>
                <x-text-input type="text" id="total_gst" name="total_gst" class="w-1/2 text-right bg-gray-50" value="{{ old('total_gst', number_format($invoice->tax_amount, 2, '.', '')) }}" readonly />
            </div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-700">Total Discount:</span>
                <x-text-input type="text" id="total_discount" name="total_discount" class="w-1/2 text-right bg-gray-50" value="{{ old('total_discount', number_format($invoice->total_discount ?? 0, 2, '.', '')) }}" readonly />
            </div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-700">Total Scheme Amount:</span>
                <x-text-input type="text" id="total_scheme_amount" name="total_scheme_amount" class="w-1/2 text-right bg-gray-50" value="{{ old('total_scheme_amount', number_format($invoice->total_scheme_amount ?? 0, 2, '.', '')) }}" readonly />
            </div>
            <div class="flex justify-between items-center border-t pt-2 mt-2">
                <span class="text-lg font-semibold text-gray-900">Grand Total:</span>
                <x-text-input type="text" id="grand_total" name="total" class="w-1/2 text-right bg-gray-50 font-semibold" value="{{ old('total', number_format($invoice->total, 2, '.', '')) }}" readonly />
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const invoiceItemsTableBody = document.querySelector('#invoice-items-table tbody');
        const addRowBtn = document.getElementById('add-row-btn');
        const noItemsRow = document.getElementById('no-items-row');

        const subtotalInput = document.getElementById('subtotal');
        const totalGstInput = document.getElementById('total_gst');
        const totalDiscountInput = document.getElementById('total_discount');
        const totalSchemeAmountInput = document.getElementById('total_scheme_amount');
        const grandTotalInput = document.getElementById('grand_total');

        let itemIndex = {{ isset($invoice) && $invoice->services->count() > 0 ? $invoice->services->count() : 0 }};

        function calculateRowAmounts(row) {
            const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
            const rate = parseFloat(row.querySelector('.rate-input').value) || 0;
            const cgst = parseFloat(row.querySelector('.cgst-input').value) || 0;
            const sgst = parseFloat(row.querySelector('.sgst-input').value) || 0;
            const igst = parseFloat(row.querySelector('.igst-input').value) || 0;
            const discountPercentage = parseFloat(row.querySelector('.discount-input').value) || 0;
            const schemeAmount = parseFloat(row.querySelector('.scheme-amount-input').value) || 0;

            const basicAmount = (rate * quantity) - (rate * quantity * discountPercentage / 100) - schemeAmount;
            const gstAmount = basicAmount * ((cgst + sgst + igst) / 100);
            const totalAmount = basicAmount + gstAmount;

            row.querySelector('.basic-amount-input').value = basicAmount.toFixed(2);
            row.querySelector('.gst-amount-input').value = gstAmount.toFixed(2);
            row.querySelector('.total-amount-input').value = totalAmount.toFixed(2);

            calculateTotals();
        }

        function calculateTotals() {
            let subtotal = 0;
            let totalGst = 0;
            let totalDiscount = 0;
            let totalSchemeAmount = 0;

            document.querySelectorAll('.invoice-item-row').forEach(row => {
                subtotal += parseFloat(row.querySelector('.basic-amount-input').value) || 0;
                totalGst += parseFloat(row.querySelector('.gst-amount-input').value) || 0;
                totalDiscount += parseFloat(row.querySelector('.discount-input').value) || 0;
                totalSchemeAmount += parseFloat(row.querySelector('.scheme-amount-input').value) || 0;
            });

            subtotalInput.value = subtotal.toFixed(2);
            totalGstInput.value = totalGst.toFixed(2);
            totalDiscountInput.value = totalDiscount.toFixed(2);
            totalSchemeAmountInput.value = totalSchemeAmount.toFixed(2);
            grandTotalInput.value = (subtotal + totalGst).toFixed(2);
        }

        // Add event listeners to existing rows
        document.querySelectorAll('.invoice-item-row').forEach(row => {
            const inputs = row.querySelectorAll('input, select');
            inputs.forEach(input => {
                input.addEventListener('input', () => calculateRowAmounts(row));
            });
        });

        // Add row button click handler
        addRowBtn.addEventListener('click', function() {
            noItemsRow.classList.add('hidden');
            const newRow = document.createElement('tr');
            newRow.classList.add('invoice-item-row');
            newRow.innerHTML = `
                <td class="p-1">
                    <select name="items[${itemIndex}][service_id]" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm service-select" required>
                        <option value="">Select a service</option>
                        @foreach($services as $s)
                            <option value="{{ $s->id }}" data-rate="{{ $s->rate }}" data-hsn="{{ $s->hsn ?? '' }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="p-1">
                    <x-text-input type="text" name="items[${itemIndex}][hsn]" class="w-full hsn-input" value="" readonly />
                </td>
                <td class="p-1">
                    <x-text-input type="number" name="items[${itemIndex}][rate]" class="w-full rate-input" value="0.00" min="0" step="0.01" required />
                </td>
                <td class="p-1">
                    <x-text-input type="number" name="items[${itemIndex}][quantity]" class="w-full quantity-input" value="1" min="1" step="1" required />
                </td>
                <td class="p-1">
                    <x-text-input type="number" name="items[${itemIndex}][cgst]" class="w-full cgst-input" value="0.00" min="0" step="0.01" required />
                </td>
                <td class="p-1">
                    <x-text-input type="number" name="items[${itemIndex}][sgst]" class="w-full sgst-input" value="0.00" min="0" step="0.01" required />
                </td>
                <td class="p-1">
                    <x-text-input type="number" name="items[${itemIndex}][igst]" class="w-full igst-input" value="0.00" min="0" step="0.01" required />
                </td>
                <td class="p-1">
                    <div class="relative">
                        <x-text-input type="number" name="items[${itemIndex}][discount]" class="w-full discount-input pr-8" value="0.00" min="0" max="100" step="0.01" />
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <span class="text-gray-500">%</span>
                        </div>
                    </div>
                </td>
                <td class="p-1">
                    <x-text-input type="number" name="items[${itemIndex}][scheme_amount]" class="w-full scheme-amount-input" value="0.00" min="0" step="0.01" />
                </td>
                <td class="p-1">
                    <x-text-input type="number" name="items[${itemIndex}][basic_amount]" class="w-full basic-amount-input" value="0.00" min="0" step="0.01" readonly />
                </td>
                <td class="p-1">
                    <x-text-input type="number" name="items[${itemIndex}][gst_amount]" class="w-full gst-amount-input" value="0.00" min="0" step="0.01" readonly />
                </td>
                <td class="p-1">
                    <x-text-input type="number" name="items[${itemIndex}][total_amount]" class="w-full total-amount-input" value="0.00" min="0" step="0.01" readonly />
                </td>
                <td class="p-1 text-center">
                    <button type="button" class="text-red-600 hover:text-red-900 remove-item-btn p-2 rounded-md border border-gray-300 inline-flex items-center justify-center" title="Remove">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            `;
            invoiceItemsTableBody.insertBefore(newRow, noItemsRow);

            // Add event listeners to the new row
            const inputs = newRow.querySelectorAll('input, select');
            inputs.forEach(input => {
                input.addEventListener('input', () => calculateRowAmounts(newRow));
            });

            // Add service select change handler
            const serviceSelect = newRow.querySelector('.service-select');
            serviceSelect.addEventListener('change', function() {
                const option = this.options[this.selectedIndex];
                const hsn = option.dataset.hsn;
                const rate = option.dataset.rate;
                newRow.querySelector('.hsn-input').value = hsn;
                newRow.querySelector('.rate-input').value = rate;
                calculateRowAmounts(newRow);
            });

            // Add remove button handler
            const removeBtn = newRow.querySelector('.remove-item-btn');
            removeBtn.addEventListener('click', function() {
                if (document.querySelectorAll('.invoice-item-row').length > 1) {
                    newRow.remove();
                    calculateTotals();
                } else {
                    noItemsRow.classList.remove('hidden');
                }
            });

            itemIndex++;
        });

        // Add remove button handlers to existing rows
        document.querySelectorAll('.remove-item-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('.invoice-item-row');
                if (document.querySelectorAll('.invoice-item-row').length > 1) {
                    row.remove();
                    calculateTotals();
                } else {
                    noItemsRow.classList.remove('hidden');
                }
            });
        });
    });
</script>
@endpush