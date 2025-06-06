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
                    <form method="POST" action="{{ route('invoices.store') }}" class="space-y-6" id="invoice-form">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Customer Dropdown -->
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

                            <!-- Invoice Date -->
                            <div>
                                <label for="invoice_date" class="block text-sm font-medium text-gray-700">Invoice Date</label>
                                <input type="date" name="invoice_date" id="invoice_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ date('Y-m-d') }}" required>
                                @error('invoice_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Invoice Number -->
                            <div>
                                <label for="invoice_number" class="block text-sm font-medium text-gray-700">Invoice Number</label>
                                <input type="text" name="invoice_number" id="invoice_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" readonly>
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
            // Function to get current financial year
            function getCurrentFinancialYear() {
                const today = new Date();
                const currentMonth = today.getMonth() + 1;
                const currentYear = today.getFullYear();
                
                if (currentMonth >= 4) {
                    return currentYear;
                } else {
                    return currentYear - 1;
                }
            }

            // Function to generate invoice number
            function generateInvoiceNumber() {
                const financialYear = getCurrentFinancialYear();
                const yearSuffix = financialYear.toString().slice(-2);
                const nextYearSuffix = (financialYear + 1).toString().slice(-2);
                return `INV/${yearSuffix}-${nextYearSuffix}/001`;
            }

            // Set initial invoice number
            document.getElementById('invoice_number').value = generateInvoiceNumber();

            // Function to add a new row
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
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="gst-amount">0.00</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="total-amount">0.00</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button type="button" class="text-red-600 hover:text-red-900 delete-row">Delete</button>
                    </td>
                `;
                tbody.appendChild(newRow);
                attachRowEventListeners(newRow);
            }

            // Function to attach event listeners to row inputs
            function attachRowEventListeners(row) {
                // Service select change event
                const serviceSelect = row.querySelector('.service-select');
                serviceSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const row = this.closest('tr');
                    
                    // Auto-fill the fields
                    row.querySelector('input[name$="[hsn]"]').value = selectedOption.dataset.hsn || '';
                    row.querySelector('input[name$="[rate]"]').value = selectedOption.dataset.rate || '';
                    row.querySelector('input[name$="[cgst]"]').value = selectedOption.dataset.cgst || '';
                    row.querySelector('input[name$="[sgst]"]').value = selectedOption.dataset.sgst || '';
                    row.querySelector('input[name$="[igst]"]').value = selectedOption.dataset.igst || '';
                    
                    // Trigger calculation
                    calculateRowAmounts({ target: row.querySelector('input[name$="[quantity]"]') });
                });

                // Quantity input event
                const quantityInput = row.querySelector('input[name$="[quantity]"]');
                quantityInput.addEventListener('input', calculateRowAmounts);

                // Discount and scheme amount inputs
                const discountInput = row.querySelector('input[name$="[discount]"]');
                const schemeInput = row.querySelector('input[name$="[scheme_amount]"]');
                discountInput.addEventListener('input', calculateRowAmounts);
                schemeInput.addEventListener('input', calculateRowAmounts);

                // Delete button
                const deleteButton = row.querySelector('.delete-row');
                deleteButton.addEventListener('click', function() {
                    row.remove();
                    calculateTotals();
                });
            }

            // Function to calculate amounts for a row
            function calculateRowAmounts(event) {
                const row = event.target.closest('tr');
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

                calculateTotals();
            }

            // Function to calculate totals
            function calculateTotals() {
                let subtotal = 0;
                let totalGst = 0;
                let totalDiscount = 0;

                document.querySelectorAll('#invoice-items tr').forEach(row => {
                    subtotal += parseFloat(row.querySelector('.basic-amount').textContent) || 0;
                    totalGst += parseFloat(row.querySelector('.gst-amount').textContent) || 0;
                    totalDiscount += parseFloat(row.querySelector('input[name$="[discount]"]').value) || 0;
                });

                document.getElementById('subtotal').textContent = subtotal.toFixed(2);
                document.getElementById('total-gst').textContent = totalGst.toFixed(2);
                document.getElementById('total-discount').textContent = totalDiscount.toFixed(2);
                document.getElementById('grand-total').textContent = (subtotal + totalGst).toFixed(2);
            }

            // Form validation
            document.getElementById('invoice-form').addEventListener('submit', function(e) {
                const rows = document.querySelectorAll('#invoice-items tr');
                if (rows.length === 0) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please add at least one service to the invoice.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                let hasEmptyFields = false;
                rows.forEach(row => {
                    const serviceSelect = row.querySelector('.service-select');
                    const quantityInput = row.querySelector('input[name$="[quantity]"]');
                    
                    if (!serviceSelect.value || !quantityInput.value) {
                        hasEmptyFields = true;
                    }
                });

                if (hasEmptyFields) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please fill in all required fields for each service.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });

            // Add event listener to Add Row button
            document.getElementById('add-row').addEventListener('click', addRow);

            // Add first row by default
            addRow();
        });
    </script>
    @endpush
</x-app-layout> 