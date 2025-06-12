<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Invoice Details') }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('invoices.edit', $invoice) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    {{ __('Edit Invoice') }}
                </a>
                <a href="{{ route('invoices.pdf', $invoice) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    {{ __('Download PDF') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 justify-items-end">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Invoice Date</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $invoice->invoice_date->format('Y-m-d') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Due Date</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $invoice->due_date->format('Y-m-d') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Invoice Number</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $invoice->invoice_number }}</p>
                        </div>
                    </div>
                    <br>

                    <!-- Company and Customer Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <!-- Company Details -->
                        @if($company)
                        <div class="border rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">From:</h3>
                            <div style="display: flex; align-items: flex-start; gap: 1rem;">
                                @if($company->logo && Storage::disk('public')->exists($company->logo))
                                    <img src="{{ Storage::url($company->logo) }}" alt="Company Logo" style="width: 80px; height: 80px; object-fit: contain; flex-shrink: 0; border: 1px solid #e5e7eb; border-radius: 4px;">
                                @else
                                    <div style="width: 80px; height: 80px; background-color: #f3f4f6; display: flex; align-items: center; justify-content: center; border: 1px solid #e5e7eb; border-radius: 4px;">
                                        <span style="font-size: 24px; color: #9ca3af;">Logo</span>
                                    </div>
                                @endif
                                <div style="flex-grow: 1;">
                                    <h4 class="text-lg font-semibold text-gray-900">{{ $company->name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $company->address }}</p>
                                    <div class="mt-2 space-y-1">
                                        <p class="text-sm text-gray-600">Phone: {{ $company->phone }}</p>
                                        <p class="text-sm text-gray-600">Email: {{ $company->email }}</p>
                                        <p class="text-sm text-gray-600">GST: {{ $company->gst }}</p>
                                        <p class="text-sm text-gray-600">PAN: {{ $company->pan }}</p>
                                        <p class="text-sm text-gray-600">State Code: {{ $company->state_code ?? 'N/A' }}</p>
                                        <p class="text-sm text-gray-600">Place of Supply: {{ $company->place_of_supply ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Customer Details -->
                        <div class="border rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Bill To:</h3>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900">{{ $invoice->customer->name }}</h4>
                                <p class="text-sm text-gray-600">{{ $invoice->customer->address }}</p>
                                <div class="mt-2 space-y-1">
                                    <p class="text-sm text-gray-600">Phone: {{ $invoice->customer->phone }}</p>
                                    <p class="text-sm text-gray-600">Email: {{ $invoice->customer->email }}</p>
                                    <p class="text-sm text-gray-600">GST: {{ $invoice->customer->gst ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-600">State Code: {{ $invoice->customer->state_code ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-600">Place of Supply: {{ $invoice->customer->place_of_supply ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 280px;">Service</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 150px;">HSN</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 150px;">Rate</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 150px;">Quantity</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 120px;">CGST</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 120px;">SGST</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 120px;">IGST</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 180px;">Discount</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 250px;">Scheme Amount</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 250px;">Basic Amount</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 250px;">GST Amount</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 250px;">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($invoice->services as $service)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $service->service->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $service->service->hsn }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($service->rate, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $service->quantity }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($service->cgst_rate, 2) }}%</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($service->sgst_rate, 2) }}%</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($service->igst_rate, 2) }}%</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($service->discount, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($service->scheme_amount ?? 0, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($service->basic_amount, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($service->gst_amount, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($service->total_amount, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="12" class="px-6 py-4 text-center text-gray-500">
                                                {{ __('No services found.') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-8 grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Notes</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $invoice->notes}}</p>
                            </div>
                            <div class="space-y-4">
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-700">Subtotal:</span>
                                    <span class="text-sm text-gray-900">{{ number_format($invoice->subtotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-700">Total GST:</span>
                                    <span class="text-sm text-gray-900">{{ number_format($invoice->tax_amount, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-700">Total Discount:</span>
                                    <span class="text-sm text-gray-900">{{ number_format($invoice->total_discount ?? 0, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-700">Total Scheme Amount:</span>
                                    <span class="text-sm text-gray-900">{{ number_format($invoice->total_scheme_amount ?? 0, 2) }}</span>
                                </div>
                                <div class="flex justify-between border-t pt-2">
                                    <span class="text-base font-medium text-gray-900">Grand Total:</span>
                                    <span class="text-base font-medium text-gray-900">{{ number_format($invoice->total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 