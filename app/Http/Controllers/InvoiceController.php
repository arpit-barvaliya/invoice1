<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Service;
use App\Models\InvoiceService;
use App\Models\Company;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('customer')->latest()->paginate(10);
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $customers = Customer::all();
        $services = Service::all();
        $invoiceNumber = $this->generateInvoiceNumber();
        return view('invoices.create', compact('customers', 'services', 'invoiceNumber'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'invoice_number' => 'required|string|unique:invoices,invoice_number',
            'items' => 'required|array|min:1',
            'items.*.service_id' => 'required|exists:services,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.rate' => 'required|numeric|min:0',
            'items.*.cgst' => 'required|numeric|min:0',
            'items.*.sgst' => 'required|numeric|min:0',
            'items.*.igst' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
            'items.*.scheme_amount' => 'nullable|numeric|min:0',
            'items.*.basic_amount' => 'required|numeric|min:0',
            'items.*.gst_amount' => 'required|numeric|min:0',
            'items.*.total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        // Calculate totals
        $subtotal = 0;
        $totalGst = 0;
        $totalDiscount = 0;

        foreach ($request->items as $item) {
            $subtotal += $item['basic_amount'];
            $totalGst += $item['gst_amount'];
            $totalDiscount += ($item['discount'] ?? 0);
        }

        $total = $subtotal + $totalGst;

        // Create invoice
        $invoice = Invoice::create([
            'invoice_number' => $validated['invoice_number'],
            'customer_id' => $validated['customer_id'],
            'invoice_date' => $validated['invoice_date'],
            'due_date' => $validated['due_date'],
            'subtotal' => $subtotal,
            'tax_amount' => $totalGst,
            'total' => $total,
            'notes' => $request->notes,
        ]);

        // Create invoice items
        foreach ($request->items as $item) {
            $invoice->services()->create([
                'service_id' => $item['service_id'],
                'quantity' => $item['quantity'],
                'rate' => $item['rate'],
                'cgst_rate' => $item['cgst'],
                'sgst_rate' => $item['sgst'],
                'igst_rate' => $item['igst'],
                'discount' => $item['discount'] ?? 0,
                'scheme_amount' => $item['scheme_amount'] ?? 0,
                'basic_amount' => $item['basic_amount'],
                'gst_amount' => $item['gst_amount'],
                'total_amount' => $item['total_amount']
            ]);
        }

        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Invoice created successfully.');
    }

    public function show(Invoice $invoice)
    {
        $company = Company::first();
        $invoice->load(['customer', 'services.service']);
        return view('invoices.show', compact('invoice', 'company'));
    }

    public function edit(Request $request, Invoice $invoice)
    {
        $customers = Customer::all();
        $services = Service::all();
        
        // Check if we're editing a specific service
        $invoiceService = null;
        if ($request->has('edit_service')) {
            $invoiceService = $invoice->services()->findOrFail($request->edit_service);
        }

        return view('invoices.edit', compact('invoice', 'customers', 'services', 'invoiceService'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'invoice_number' => 'required|string|unique:invoices,invoice_number,' . $invoice->id
        ]);

        $invoice->update($validated);

        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice)
    {
        // Delete related invoice services first
        $invoice->services()->delete();
        
        // Force delete the invoice
        $invoice->forceDelete();
        
        return redirect()->route('invoices.index')
            ->with('success', 'Invoice deleted successfully.');
    }

    public function pdf(Invoice $invoice)
    {
        $company = Company::first();
        $pdf = PDF::loadView('invoices.pdf', compact('invoice', 'company'));
        return $pdf->stream('invoice-' . str_replace(['/', '\\'], '-', $invoice->invoice_number) . '.pdf');
    }

    protected function getCurrentFinancialYear()
    {
        $today = Carbon::now();
        $currentMonth = $today->month;
        $currentYear = $today->year;
        
        if ($currentMonth >= 4) {
            return [
                'start' => $currentYear,
                'end' => $currentYear + 1,
                'code' => substr($currentYear, -2) . '-' . substr($currentYear + 1, -2)
            ];
        } else {
            return [
                'start' => $currentYear - 1,
                'end' => $currentYear,
                'code' => substr($currentYear - 1, -2) . '-' . substr($currentYear, -2)
            ];
        }
    }

    protected function generateInvoiceNumber()
    {
        $prefix = config('app.invoice_prefix', 'INV');
        $financialYear = $this->getCurrentFinancialYear();
        
        // Get the last invoice number for the current financial year
        $lastInvoice = Invoice::where('invoice_number', 'like', $prefix . '/' . $financialYear['code'] . '/%')
            ->orderBy('invoice_number', 'desc')
            ->first();
        
        if ($lastInvoice) {
            // Extract the number part and increment it
            $parts = explode('/', $lastInvoice->invoice_number);
            $number = (int) $parts[2] + 1;
        } else {
            $number = 1;
        }
        
        // Format the number with leading zeros
        $formattedNumber = str_pad($number, 3, '0', STR_PAD_LEFT);
        
        return $prefix . '/' . $financialYear['code'] . '/' . $formattedNumber;
    }
}
