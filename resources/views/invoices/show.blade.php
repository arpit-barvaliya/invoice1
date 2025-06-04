<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Invoice Details') }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('invoices.edit', $invoice) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Edit Invoice') }}
                </a>
                <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150" onclick="return confirm('Are you sure you want to delete this invoice?')">
                        {{ __('Delete Invoice') }}
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                            <dl class="grid grid-cols-1 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Invoice Number</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $invoice->invoice_number }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Customer</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $invoice->customer->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($invoice->status === 'paid') bg-green-100 text-green-800
                                            @elseif($invoice->status === 'overdue') bg-red-100 text-red-800
                                            @elseif($invoice->status === 'sent') bg-blue-100 text-blue-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($invoice->status) }}
                                        </span>
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Dates</h3>
                            <dl class="grid grid-cols-1 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Invoice Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $invoice->invoice_date->format('F j, Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Due Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $invoice->due_date->format('F j, Y') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Services</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rate</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($invoice->services as $service)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $service->service->name }}</td>
                                            <td class="px-6 py-4">{{ $service->description }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $service->quantity }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($service->rate, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($service->amount, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No services added to this invoice.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-right font-medium text-gray-500">Subtotal:</td>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium">{{ number_format($invoice->subtotal, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-right font-medium text-gray-500">Tax ({{ $invoice->tax_rate }}%):</td>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium">{{ number_format($invoice->tax_amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-right font-medium text-gray-900">Total:</td>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ number_format($invoice->total, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    @if($invoice->notes)
                        <div class="mt-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Notes</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-900">{{ $invoice->notes }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 