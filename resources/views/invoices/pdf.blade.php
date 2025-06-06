<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 15px;
            color: #333;
            line-height: 1.5;
            font-size: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #1E40AF; /* Tailwind indigo-800 */
            margin: 0;
            font-size: 1.8em;
        }
        .invoice-details {
            margin-bottom: 20px;
        }
        .invoice-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-details th, .invoice-details td {
            padding: 5px 8px;
            text-align: left;
        }
        .address-section {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .address-section td {
            width: 50%;
            vertical-align: top;
            padding: 0 10px;
        }
        .address-section h3 {
            color: #1E40AF; /* Tailwind indigo-800 */
            margin-top: 0;
            margin-bottom: 8px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 4px;
            font-size: 1.1em;
        }
        .address-details p {
            margin: 3px 0;
        }
        .services-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .services-table th, .services-table td {
            border: 1px solid #ddd;
            padding: 8px 10px;
            text-align: left;
        }
        .services-table th {
            background-color: #EFF6FF; /* Tailwind blue-100 */
            color: #1E40AF; /* Tailwind indigo-800 */
            font-weight: bold;
        }
        .services-table tbody tr:nth-child(even) {
            background-color: #F9FAFB; /* Tailwind gray-50 */
        }
        .totals-section {
            width: 250px;
            margin-left: auto;
            margin-top: 15px;
        }
        .totals-section table {
            width: 100%;
            border-collapse: collapse;
        }
        .totals-section td {
            padding: 5px 8px;
        }
        .totals-section .subtotal-row td {
            border-top: 1px solid #ddd;
            font-weight: bold;
        }
         .totals-section .grand-total-row td {
            border-top: 2px solid #333;
            font-weight: bold;
            font-size: 1.2em;
        }
        .notes {
            margin-top: 30px;
            padding: 10px;
            background-color: #F3F4F6; /* Tailwind gray-100 */
            border-left: 4px solid #1E40AF; /* Tailwind indigo-800 */
        }
        .notes p {
            margin: 0;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .amount-in-words {
            margin-top: 10px;
            font-style: italic;
            color: #4B5563; /* Tailwind gray-600 */
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>INVOICE</h1>
    </div>

    <div class="invoice-details">
        <table>
            <tr>
                <td><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</td>
                <td><strong>Invoice Date:</strong> {{ $invoice->invoice_date->format('Y-m-d') }}</td>
                <td><strong>Due Date:</strong> {{ $invoice->due_date->format('Y-m-d') }}</td>
            </tr>
        </table>
    </div>

    <table class="address-section">
        <tr>
            <td>
                <div class="company-details">
                    <h3>From:</h3>
                    <div class="address-details">
                        @if($company)
                            <p><strong>{{ $company->name }}</strong></p>
                            <p>{{ $company->address }}</p>
                            <p>Phone: {{ $company->phone }}</p>
                            <p>Email: {{ $company->email }}</p>
                            <p>GST: {{ $company->gst }}</p>
                            <p>PAN: {{ $company->pan }}</p>
                            <p>State Code: {{ $company->state_code ?? 'N/A' }}</p>
                            <p>Place of Supply: {{ $company->place_of_supply ?? 'N/A' }}</p>
                        @endif
                    </div>
                </div>
            </td>
            <td>
                <div class="customer-details">
                    <h3>Bill To:</h3>
                    <div class="address-details">
                        <p><strong>{{ $invoice->customer->name }}</strong></p>
                        <p>{{ $invoice->customer->address }}</p>
                        <p>Phone: {{ $invoice->customer->phone }}</p>
                        <p>Email: {{ $invoice->customer->email }}</p>
                        <p>GST: {{ $invoice->customer->gst ?? 'N/A' }}</p>
                        <p>State Code: {{ $invoice->customer->state_code ?? 'N/A' }}</p>
                        <p>Place of Supply: {{ $invoice->customer->place_of_supply ?? 'N/A' }}</p>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <table class="services-table">
        <thead>
            <tr>
                <th>Service</th>
                <th>HSN</th>
                <th>Rate</th>
                <th>Quantity</th>
                <th>CGST</th>
                <th>SGST</th>
                <th>IGST</th>
                <th>Discount</th>
                <th>Scheme</th>
                <th>Basic Amount</th>
                <th>GST Amount</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->services as $service)
                <tr>
                    <td>{{ $service->service->name }}</td>
                    <td>{{ $service->service->hsn }}</td>
                    <td>{{ number_format($service->rate, 2) }}</td>
                    <td>{{ $service->quantity }}</td>
                    <td>{{ number_format($service->cgst_rate, 2) }}%</td>
                    <td>{{ number_format($service->sgst_rate, 2) }}%</td>
                    <td>{{ number_format($service->igst_rate, 2) }}%</td>
                    <td>{{ number_format($service->discount, 2) }}</td>
                    <td>{{ number_format($service->scheme_amount, 2) }}</td>
                    <td>{{ number_format($service->basic_amount, 2) }}</td>
                    <td>{{ number_format($service->gst_amount, 2) }}</td>
                    <td>{{ number_format($service->total_amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals-section">
        <table>
            <tr class="subtotal-row">
                <td>Subtotal:</td>
                <td align="right">{{ number_format($invoice->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td>Total GST:</td>
                <td align="right">{{ number_format($invoice->tax_amount, 2) }}</td>
            </tr>
            <tr class="grand-total-row">
                <td>Grand Total:</td>
                <td align="right">{{ number_format($invoice->total, 2) }}</td>
            </tr>
        </table>
        <div class="amount-in-words">
            Amount in words: {{ ucwords(App\Helpers\NumberToWords::convert($invoice->total)) }} Rupees Only
        </div>
    </div>

    @if($invoice->notes)
        <div class="notes">
            <strong>Notes:</strong><br>
            <p>{{ $invoice->notes }}</p>
        </div>
    @endif

    <div class="footer">
        <p>This is a computer-generated invoice. No signature is required.</p>
    </div>
</body>
</html> 