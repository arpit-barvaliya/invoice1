<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->paginate(10);
        return view('services.index', compact('services'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateService($request);

        Service::create($validated);

        return redirect()->route('services.index')
            ->with('success', 'Service created successfully.');
    }

    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $this->validateService($request);

        $service->update($validated);

        return redirect()->route('services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('services.index')
            ->with('success', 'Service deleted successfully.');
    }

    protected function validateService(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'hsn' => 'nullable|string|max:50',
            'rate' => 'required|numeric|min:0',
            'cgst_rate' => 'required|numeric|min:0|max:100',
            'sgst_rate' => 'required|numeric|min:0|max:100',
            'igst_rate' => 'required|numeric|min:0|max:100'
        ]);
    }
}
