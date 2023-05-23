<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
use App\Models\Company;
use App\Models\Section;
use App\Models\User;
use App\Models\UserSection;
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

    public function store(StoreSectionRequest $request, $company_id): RedirectResponse
    {
        $section = New Section();
        $company = Company::findOrFail($company_id);

        $section->create([
           'company_id' => $company->id,
           'name' => $request->name
        ]);

        return redirect()
            ->route('companies.show', compact('company'))
            ->with('status', 'Section Created!');
    }

    public function edit($company_id, $section_id): View {
        $company = Company::findOrFail($company_id);
        $section = Section::findOrFail($section_id);

        return view('companies.sections.edit', compact('company', 'section'));
    }

    public function update(UpdateSectionRequest $request, Company $company, Section $section): RedirectResponse
    {
        $section->fill($request->validated())
            ->save();
        return redirect()->route('companies.show', compact('company'));

    }
}
