<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function index()
    {
        $company = auth()->user()->company ?? new Company();
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
            try {
                $file = $request->file('logo');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('company-logos', $filename, 'public');
    
                if ($path) {
                    $data['logo'] = $path;
                } else {
                    return redirect()->back()->withInput()->with('error', 'Logo upload failed.');
                }
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Error uploading logo: ' . $e->getMessage());
            }
        }
    
        DB::beginTransaction();
        try {
            $company = Company::create($data);
    
            if (!Auth::user()->company_id) {
                Auth::user()->update(['company_id' => $company->id]);
            }
    
            DB::commit();
            return redirect()->route('company.index')->with('success', 'Company created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Error creating company: ' . $e->getMessage());
        }
    }
    
    public function show(Company $company)
    {
        if ($company->id !== Auth::user()->company_id) {
            return redirect()->route('company.index')->with('error', 'Unauthorized access.');
        }
        return view('company.show', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        if ($company->id !== Auth::user()->company_id) {
            return redirect()->route('company.index')->with('error', 'Unauthorized access.');
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
            try {
                if ($company->logo) {
                    Storage::disk('public')->delete($company->logo);
                }

                $file = $request->file('logo');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('company-logos', $filename, 'public');

                if ($path) {
                    $data['logo'] = $path;
                } else {
                    return redirect()->back()->withInput()->with('error', 'Logo upload failed.');
                }
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Error uploading logo: ' . $e->getMessage());
            }
        }

        DB::beginTransaction();
        try {
            $company->update($data);
            DB::commit();
            return redirect()->route('company.index')->with('success', 'Company updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Error updating company: ' . $e->getMessage());
        }
    }

    public function destroy(Company $company)
    {
        if ($company->id !== Auth::user()->company_id) {
            return redirect()->route('company.index')->with('error', 'Unauthorized access.');
        }

        DB::beginTransaction();
        try {
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            $company->delete();
            DB::commit();
            return redirect()->route('company.index')->with('success', 'Company deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error deleting company: ' . $e->getMessage());
        }
    }

    public function switchCompany(Company $company)
    {
        if ($company->id !== Auth::user()->company_id) {
            return redirect()->route('company.index')->with('error', 'Unauthorized access.');
        }

        try {
            Auth::user()->update(['company_id' => $company->id]);
            return redirect()->route('company.index')->with('success', 'Company switched successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error switching company: ' . $e->getMessage());
        }
    }
} 