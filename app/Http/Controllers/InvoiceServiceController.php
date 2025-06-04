<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceService;
use App\Models\Service;
use Illuminate\Http\Request;

class InvoiceServiceController extends Controller
{
    public function store(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'quantity' => 'required|integer|min:1',
            'rate' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000'
        ]);

        $service = Service::findOrFail($validated['service_id']);
        $amount = $validated['quantity'] * $validated['rate'];

        $invoiceService = $invoice->services()->create([
            'service_id' => $validated['service_id'],
            'quantity' => $validated['quantity'],
            'rate' => $validated['rate'],
            'amount' => $amount,
            'description' => $validated['description']
        ]);

        // Update invoice totals
        $this->updateInvoiceTotals($invoice);

        return redirect()->back()->with('success', 'Service added successfully.');
    }

    public function update(Request $request, Invoice $invoice, InvoiceService $invoiceService)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'rate' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000'
        ]);

        $amount = $validated['quantity'] * $validated['rate'];

        $invoiceService->update([
            'quantity' => $validated['quantity'],
            'rate' => $validated['rate'],
            'amount' => $amount,
            'description' => $validated['description']
        ]);

        // Update invoice totals
        $this->updateInvoiceTotals($invoice);

        return redirect()->back()->with('success', 'Service updated successfully.');
    }

    public function destroy(Invoice $invoice, InvoiceService $invoiceService)
    {
        $invoiceService->delete();

        // Update invoice totals
        $this->updateInvoiceTotals($invoice);

        return redirect()->back()->with('success', 'Service removed successfully.');
    }

    private function updateInvoiceTotals(Invoice $invoice)
    {
        $subtotal = $invoice->services()->sum('amount');
        $taxAmount = $subtotal * ($invoice->tax_rate / 100);
        $total = $subtotal + $taxAmount;

        $invoice->update([
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'total' => $total
        ]);
    }
}
