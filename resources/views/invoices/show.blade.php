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
                <a href="{{ route('invoices.pdf', $invoice) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Download PDF') }}
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
                    <!-- Invoice Header -->
                    <div class="mb-8 border-b pb-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900">INVOICE</h4>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600">Invoice No: {{ $invoice->invoice_number }}</p>
                                <p class="text-sm text-gray-600 mt-2">Invoice Date: {{ $invoice->invoice_date->format('F j, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Company and Customer Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <!-- Company Details -->
                        @if($company)
                        <div class="border rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">From:</h3>
                            <div class="flex items-start space-x-4">
                                @if($company->logo)
                                    <img src="{{ Storage::url($company->logo) }}" alt="Company Logo" class="h-20 w-20 object-contain">
                                @endif
                                <div>
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

                    <!-- Services Table -->
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Services</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sr. No.</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rate</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($invoice->services as $index => $service)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $service->service->name }}</td>
                                            <td class="px-6 py-4">{{ $service->description }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $service->quantity }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($service->rate, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($service->amount, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No services added to this invoice.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <td colspan="5" class="px-10 py-1 text-right font-medium text-gray-500">Subtotal:</td>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-right">{{ number_format($invoice->subtotal, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-right font-medium text-gray-900">Total:</td>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 text-right">{{ number_format($invoice->total, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    {{-- Total in Words and Bank Details --}}
                    <div class="mt-8">
                        <div class="text-right">
                            @php
                                function numberToWords($number) {
                                    $hyphen      = '-';
                                    $conjunction = ' and ';
                                    $separator   = ', ';
                                    $negative    = 'negative ';
                                    $decimal     = ' point ';
                                    $dictionary  = [
                                        0 => 'zero',
                                        1 => 'one',
                                        2 => 'two',
                                        3 => 'three',
                                        4 => 'four',
                                        5 => 'five',
                                        6 => 'six',
                                        7 => 'seven',
                                        8 => 'eight',
                                        9 => 'nine',
                                        10 => 'ten',
                                        11 => 'eleven',
                                        12 => 'twelve',
                                        13 => 'thirteen',
                                        14 => 'fourteen',
                                        15 => 'fifteen',
                                        16 => 'sixteen',
                                        17 => 'seventeen',
                                        18 => 'eighteen',
                                        19 => 'nineteen',
                                        20 => 'twenty',
                                        30 => 'thirty',
                                        40 => 'forty',
                                        50 => 'fifty',
                                        60 => 'sixty',
                                        70 => 'seventy',
                                        80 => 'eighty',
                                        90 => 'ninety',
                                        100 => 'hundred',
                                        1000 => 'thousand',
                                        100000 => 'lakh',
                                        10000000 => 'crore'
                                    ];
                                    if (!is_numeric($number)) {
                                        return false;
                                    }
                                    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
                                        // overflow
                                        return false;
                                    }
                                    if ($number < 0) {
                                        return $negative . numberToWords(abs($number));
                                    }
                                    $string = $fraction = null;
                                    if (strpos($number, '.') !== false) {
                                        list($number, $fraction) = explode('.', $number);
                                    }
                                    switch (true) {
                                        case $number < 21:
                                            $string = $dictionary[$number];
                                            break;
                                        case $number < 100:
                                            $tens   = ((int) ($number / 10)) * 10;
                                            $units  = $number % 10;
                                            $string = $dictionary[$tens];
                                            if ($units) {
                                                $string .= $hyphen . $dictionary[$units];
                                            }
                                            break;
                                        case $number < 1000:
                                            $hundreds  = (int) ($number / 100);
                                            $remainder = $number % 100;
                                            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                                            if ($remainder) {
                                                $string .= $conjunction . numberToWords($remainder);
                                            }
                                            break;
                                        case $number < 100000:
                                            $thousands   = (int) ($number / 1000);
                                            $remainder = $number % 1000;
                                            $string = numberToWords($thousands) . ' ' . $dictionary[1000];
                                            if ($remainder) {
                                                $string .= $separator . numberToWords($remainder);
                                            }
                                            break;
                                        case $number < 10000000:
                                            $lakhs   = (int) ($number / 100000);
                                            $remainder = $number % 100000;
                                            $string = numberToWords($lakhs) . ' ' . $dictionary[100000];
                                            if ($remainder) {
                                                $string .= $separator . numberToWords($remainder);
                                            }
                                            break;
                                        default:
                                            $crores   = (int) ($number / 10000000);
                                            $remainder = $number % 10000000;
                                            $string = numberToWords($crores) . ' ' . $dictionary[10000000];
                                            if ($remainder) {
                                                $string .= $separator . numberToWords($remainder);
                                            }
                                            break;
                                    }
                                    if (null !== $fraction && is_numeric($fraction)) {
                                        $string .= $decimal;
                                        $words = [];
                                        foreach (str_split((string) $fraction) as $number) {
                                            $words[] = $dictionary[$number];
                                        }
                                        $string .= implode(' ', $words);
                                    }
                                    return $string;
                                }
                            @endphp
                            <div class="font-semibold text-gray-700 mt-4">
                                Amount in Words: <span class="italic">{{ ucfirst(numberToWords((int)$invoice->total)) }} only</span>
                            </div>
                            <div class="mt-6 p-4 border rounded bg-gray-50 inline-block text-left">
                                <div class="font-semibold mb-2">Bank Details</div>
                                <div>Bank Name: HDFC Bank</div>
                                <div>Account Number: 1234567890</div>
                                <div>IFSC Code: HDFC0001234</div>
                                <div>Branch: Main Branch, City</div>
                            </div>
                        </div>
                    </div>

                    {{-- @if($invoice->notes)
                        <div class="mt-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Notes</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-900">{{ $invoice->notes }}</p>
                            </div>
                        </div>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 