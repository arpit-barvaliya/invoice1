<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Services</h3>

    <form action="{{ isset($invoiceService) ? route('invoice-services.update', [$invoice, $invoiceService]) : route('invoice-services.store', $invoice) }}" method="POST" class="space-y-4">
        @csrf
        @if(isset($invoiceService))
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="service_id" value="Service" />
                <select name="service_id" id="service_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" {{ isset($invoiceService) ? 'disabled' : '' }}>
                    <option value="">Select a service</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ (isset($invoiceService) && $invoiceService->service_id == $service->id) ? 'selected' : '' }}>
                            {{ $service->name }} ({{ $service->rate }}/{{ $service->unit }})
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('service_id')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="quantity" value="Quantity" />
                <x-text-input id="quantity" name="quantity" type="number" class="mt-1 block w-full" :value="old('quantity', $invoiceService->quantity ?? '')" min="1" step="1" required />
                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="rate" value="Rate" />
                <x-text-input id="rate" name="rate" type="number" class="mt-1 block w-full" :value="old('rate', $invoiceService->rate ?? '')" min="0" step="0.01" required />
                <x-input-error :messages="$errors->get('rate')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="amount" value="Amount" />
                <x-text-input id="amount" type="number" class="mt-1 block w-full bg-gray-50" :value="old('amount', $invoiceService->amount ?? '')" disabled />
            </div>
        </div>

        <div>
            <x-input-label for="description" value="Description" />
            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('description', $invoiceService->description ?? '') }}</textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <div class="flex justify-end">
            <x-primary-button>
                {{ isset($invoiceService) ? 'Update Service' : 'Add Service' }}
            </x-primary-button>
        </div>
    </form>

    @if(isset($invoice) && $invoice->services->count() > 0)
        <div class="mt-8">
            <h4 class="text-lg font-medium text-gray-900 mb-4">Added Services</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rate</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($invoice->services as $service)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $service->service->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $service->quantity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ number_format($service->rate, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ number_format($service->amount, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('invoices.edit', $invoice) }}?edit_service={{ $service->id }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                    <form action="{{ route('invoice-services.destroy', [$invoice, $service]) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to remove this service?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quantityInput = document.getElementById('quantity');
        const rateInput = document.getElementById('rate');
        const amountInput = document.getElementById('amount');

        function calculateAmount() {
            const quantity = parseFloat(quantityInput.value) || 0;
            const rate = parseFloat(rateInput.value) || 0;
            const amount = quantity * rate;
            amountInput.value = amount.toFixed(2);
        }

        quantityInput.addEventListener('input', calculateAmount);
        rateInput.addEventListener('input', calculateAmount);
    });
</script>
@endpush 