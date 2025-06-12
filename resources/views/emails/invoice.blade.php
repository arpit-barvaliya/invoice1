<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .pdf-container {
            margin: 20px 0;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .pdf-container object {
            width: 100%;
            height: 800px;
            border: none;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 0.9em;
            color: #666;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Invoice #{{ $invoice->invoice_number }}</h2>
        </div>
        
        <div class="pdf-container">
            <object data="data:application/pdf;base64,{{ $pdfContent }}" type="application/pdf">
                <p>Your browser does not support embedded PDFs. Please download the PDF to view it: 
                    <a href="data:application/pdf;base64,{{ $pdfContent }}" download="invoice.pdf">Download PDF</a>
                </p>
            </object>
        </div>
        
        <div class="footer">
            <p>Thank you for your business!</p>
            <p>Best regards,<br>
            {{ auth()->user()->company->name }}</p>
        </div>
    </div>
</body>
</html> 