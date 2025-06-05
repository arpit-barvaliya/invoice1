<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function index()
    {
        $company = Company::first();
        return view('company.index', compact('company'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'gst' => 'required|string|max:20',
            'pan' => 'required|string|max:20',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->except('logo');
        
        if ($request->hasFile('logo')) {
            if (Company::first() && Company::first()->logo) {
                Storage::delete(Company::first()->logo);
            }
            $data['logo'] = $request->file('logo')->store('company-logos', 'public');
        }

        Company::updateOrCreate(['id' => 1], $data);

        return redirect()->route('company.index')->with('success', 'Company details updated successfully');
    }
} 