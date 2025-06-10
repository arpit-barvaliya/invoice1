<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function index()
    {
        $company = Auth::user()->company ?? new Company();
        return view('company.index', compact('company'));
    }

    public function create()
    {
        return view('company.create');
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
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'state_code' => 'nullable|string|max:10',
            'place_of_supply' => 'nullable|string|max:255'
        ]);

        $data = $request->except('logo');
        $data['user_id'] = auth()->id();
        
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('company-logos', 'public');
        }

        $company = Company::create($data);

        // If this is the first company, assign it to the current user
        if (!Auth::user()->company_id) {
            Auth::user()->update(['company_id' => $company->id]);
        }

        return redirect()->route('company.index')
            ->with('success', 'Company created successfully');
    }

    public function show(Company $company)
    {
        if ($company->id !== Auth::user()->company_id) {
            return redirect()->route('company.index')
                ->with('error', 'You do not have access to this company');
        }
        return view('company.show', compact('company'));
    }

    public function edit(Company $company)
    {
        if ($company->id !== Auth::user()->company_id) {
            return redirect()->route('company.index')
                ->with('error', 'You do not have access to this company');
        }
        return view('company.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        if ($company->id !== Auth::user()->company_id) {
            return redirect()->route('company.index')
                ->with('error', 'You do not have access to this company');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'gst' => 'required|string|max:20',
            'pan' => 'required|string|max:20',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'state_code' => 'nullable|string|max:10',
            'place_of_supply' => 'nullable|string|max:255'
        ]);

        $data = $request->except('logo');
        
        if ($request->hasFile('logo')) {
            if ($company->logo) {
                Storage::delete($company->logo);
            }
            $data['logo'] = $request->file('logo')->store('company-logos', 'public');
        }

        $company->update($data);

        return redirect()->route('company.index')
            ->with('success', 'Company updated successfully');
    }

    public function destroy(Company $company)
    {
        if ($company->id !== Auth::user()->company_id) {
            return redirect()->route('company.index')
                ->with('error', 'You do not have access to this company');
        }

        if ($company->logo) {
            Storage::delete($company->logo);
        }

        $company->delete();

        return redirect()->route('company.index')
            ->with('success', 'Company deleted successfully');
    }

    public function switchCompany(Company $company)
    {
        if (!Auth::user()->company_id) {
            Auth::user()->update(['company_id' => $company->id]);
            return redirect()->route('company.index')
                ->with('success', 'Company switched successfully');
        }
        
        return redirect()->route('company.index')
            ->with('error', 'You already belong to a company');
    }
} 