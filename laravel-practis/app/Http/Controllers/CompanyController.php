<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // 複数の会社を一覧表示するので、変数は複数形で
        $companies = Auth::user()
            ->company()
            ->paginate()
            ->withQueryString();

        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request): RedirectResponse
    {
        $company = new Company();

        $company->fill($request->validated())
            ->save();

        return redirect()
            ->route('companies.show', compact('company'))
            ->with('status', 'Company Created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company): View
    {
        $this->authorize('view', $company);

        $sections = $company->sections()
            ->paginate()
            ->withQueryString();;
        return view('companies.show', compact('company', 'sections'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company): View
    {
        $this->authorize('view', $company);

        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company): RedirectResponse
    {
        $this->authorize('update', $company);

        $company->fill($request->validated())
            ->save();

        return redirect()->route('companies.show', compact('company'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company): RedirectResponse
    {
        $this->authorize('delete', $company);

        $company->delete();

        return redirect()->route('companies.index');
    }
}
