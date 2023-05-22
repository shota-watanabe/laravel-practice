<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSectionRequest;
use App\Models\Company;
use App\Models\Section;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    public function create($id): View
    {
        $company = Company::findOrFail($id);

        return view('companies.sections.create', compact('company'));
    }

    public function store(StoreSectionRequest $request, $companyId): RedirectResponse
    {
        $section = New Section();
        $company = Company::findOrFail($companyId);
        // $company->sections->fill($request->validated())->save();

        // $request->validated();
        $section->create([
           'company_id' => $company->id,
           'name' => $request->name
        ]);

        return redirect()
            ->route('companies.index')
            ->with('status', 'Section Created!');
    }
}
