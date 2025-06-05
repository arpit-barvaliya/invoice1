<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .company-details, .customer-details {
            margin-bottom: 20px;
        }
        .invoice-details {
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .totals {
            width: 300px;
            margin-left: auto;
        }
        .totals table {
            margin-bottom: 10px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>INVOICE</h1>
    </div>

    <div class="invoice-details">
        <p><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</p>
        <p><strong>Date:</strong> {{ $invoice->invoice_date->format('F j, Y') }}</p>
        <p><strong>Due Date:</strong> {{ $invoice->due_date->format('F j, Y') }}</p>
    </div>

    <div class="company-details">
        <h3>From:</h3>
        <p><strong>{{ $company->name }}</strong></p>
        <p>{{ $company->address }}</p>
        <p>Phone: {{ $company->phone }}</p>
        <p>Email: {{ $company->email }}</p>
        <p>GST: {{ $company->gst }}</p>
        <p>PAN: {{ $company->pan }}</p>
    </div>

    <div class="customer-details">
        <h3>Bill To:</h3>
        <p><strong>{{ $invoice->customer->name }}</strong></p>
        <p>{{ $invoice->customer->address }}</p>
        <p>Phone: {{ $invoice->customer->phone }}</p>
        <p>Email: {{ $invoice->customer->email }}</p>
        @if($invoice->customer->gst)
            <p>GST: {{ $invoice->customer->gst }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>Sr. No.</th>
                <th>Service</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Rate</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->services as $index => $service)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $service->service->name }}</td>
                    <td>{{ $service->description }}</td>
                    <td>{{ $service->quantity }}</td>
                    <td>{{ number_format($service->rate, 2) }}</td>
                    <td>{{ number_format($service->amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <td><strong>Subtotal:</strong></td>
                <td>{{ number_format($invoice->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Total:</strong></td>
                <td>{{ number_format($invoice->total, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Thank you for your business!</p>
        <p>This is a computer generated invoice, no signature required.</p>
    </div>
</body>
</html> 