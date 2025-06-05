<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Service;
use App\Models\InvoiceService;
use App\Models\Company;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
        $services = Service::where('is_active', true)->get();
        return view('invoices.create', compact('customers', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string|max:1000',
            'status' => 'required|in:draft,sent,paid,overdue'
        ]);

        // Generate invoice number
        $lastInvoice = Invoice::latest()->first();
        $invoiceNumber = 'INV-' . str_pad(($lastInvoice ? $lastInvoice->id + 1 : 1), 6, '0', STR_PAD_LEFT);

        $invoice = Invoice::create([
            'invoice_number' => $invoiceNumber,
            'customer_id' => $validated['customer_id'],
            'invoice_date' => $validated['invoice_date'],
            'due_date' => $validated['due_date'],
            'tax_rate' => $validated['tax_rate'],
            'notes' => $validated['notes'],
            'status' => $validated['status'],
            'subtotal' => 0,
            'tax_amount' => 0,
            'total' => 0
        ]);

        return redirect()->route('invoices.edit', $invoice)
            ->with('success', 'Invoice created successfully. Now add services to the invoice.');
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
        $services = Service::where('is_active', true)->get();
        
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
            'tax_rate' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string|max:1000',
            'status' => 'required|in:draft,sent,paid,overdue'
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
}
